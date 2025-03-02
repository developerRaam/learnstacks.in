<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(){

        $data['heading_title'] = "Media Manager";
        $data['list_title'] = "Media";

        $data['breadcrumbs'][] = [
            'text' => 'Home',
            'href' => route('admin.dashboard'),
        ];
        $data['breadcrumbs'][] = [
            'text' => 'Media',
            'href' => null
        ];

        return view('admin.media.media',$data);
    }

    public function uploadFile(Request $request){
        
        if($request->hasFile('files')){
            $files = $request->file('files'); // get files
            
            foreach ($files as $file) {               
                $file->store('media', 'public');
            }
            return response()->json([
                'error' => 0,
                'message' => 'Files uploaded successfully'
            ], 200);
        }
        return response()->json([
            'error' => 1,
            'message' => 'No files found in request'
        ], 400);
    }


    public function getFiles(){

        $folderPath = 'media';
        
        if (!Storage::disk('public')->exists($folderPath)) {
            return response()->json(['error' => 'Directory does not exist'], 404);
        }
        // Get all files and directories within the folder
        $allItems = Storage::disk('public')->allFiles($folderPath);
        $allDirs = Storage::disk('public')->allDirectories($folderPath);

        $folders = [];
        $files = [];

        // Process files
        foreach ($allItems as $file) {
            $files[] = [
                'href' => Storage::url($file), // Public URL of the file
                'text' => basename($file),     // Get file name only
            ];
        }
        // Process directories
        foreach ($allDirs as $dir) {
            $folders[] = [
                'href' => url('storage/' . $dir), // Public URL for the folder
                'text' => basename($dir),         // Get folder name
            ];
        }
        return response()->json([
            'folders' => $folders,
            'files' => $files,
        ]);
    }

    public function createFolder(Request $request){
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);
        $folderName = trim($request->input('folder_name'));
        $folderPath = 'media/' . $folderName;

        if (Storage::disk('public')->exists($folderPath)) {
            return response()->json([
                'error' => 1,
                'message' => 'Folder already exists',
            ], 400);
        }

        Storage::disk('public')->makeDirectory($folderPath);

        return response()->json([
            'error' => 0,
            'message' => 'Folder created successfully',
            'folder_path' => Storage::url($folderPath),
        ], 201);
    }

    // delete files
    public function delete(Request $request)
    {
        // check permission
        if (!auth()->user()->can('delete_media')) {
            return response()->json([
                'success' => false,
                'message' => 'You don\'t have permission to delete media'
            ]);
        }

        $request->validate([
            'files' => 'required|array',
        ]);

        $files = $request->input('files');

        if (empty($files)) {
            return response()->json([
                'success' => false,
                'message' => 'No files provided'
            ]);
        }

        $deleted = [];
        $notFound = [];

        // Loop through each file or folder
        foreach ($files as $filePath) {
            $filePath = 'media/' . trim($filePath);

            // Check if it's a file or folder and delete accordingly
            if (Storage::disk('public')->exists($filePath)) {
                if (Storage::disk('public')->delete($filePath)) {
                    $deleted[] = $filePath;
                }
                if (Storage::disk('public')->deleteDirectory($filePath)) {
                    $deleted[] = $filePath;
                }
            } elseif (Storage::disk('public')->exists($filePath) && Storage::disk('public')->deleteDirectory($filePath)) {
                $deleted[] = $filePath;
            } else {
                $notFound[] = $filePath;
            }
        }

        // Prepare response
        return response()->json([
            'success' => true,
            'message' => 'Files deleted successfully',
        ]);
    }

    public function openFolder(){
        
    }
}
