<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Barryvdh\DomPDF\Facade\Pdf;


class ImageController extends Controller
{
    public function imageCompress(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('tools.image-compress');
        }

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:5120',
            'quality' => 'required|numeric|min:10|max:100',
        ]);
        
        $quality = (int) $request->input('quality', 90);

        // Get uploaded file
        $imageFile = $request->file('image');

        // Initialize image manager (using GD driver)
        $manager = new ImageManager(new Driver());
        $image = $manager->read($imageFile->getPathname());
        
        $compressedName = 'compressed_' . time() . '.jpg';
        $finalPath = 'tools/compressedImage/' . $compressedName;
        
        Storage::disk('public')->put($finalPath, $image->toJpeg(quality: $quality));

        // Get file size in KB
        $fileSize = round(Storage::disk('public')->size($finalPath) / 1024, 2) . 'KB'; // in KB

        // Return JSON response
        $response = [
            'path' => Storage::url($finalPath),
            'size_kb' => $fileSize,
        ];

        return back()->with($response);
    }


    public function convertJpgToPng(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('tools.image-jpg-to-png');
        }

        // Handle POST method
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg|max:5120'
        ]);
        
        // Get uploaded file
        $imageFile = $request->file('image');

        // Initialize image manager (using GD driver)
        $manager = new ImageManager(new Driver());
        $image = $manager->read($imageFile->getPathname());
        
        $compressedName = time() . '.png';
        $finalPath = 'tools/convertImage/' . $compressedName;
        
        Storage::disk('public')->put($finalPath, $image->toPng());

        // Return JSON response
        $response = [
            'path' => Storage::url($finalPath)
        ];

        return back()->with($response);
    }

    public function convertPngToJpg(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('tools.image-png-to-jpg');
        }

        // Handle POST method
        $request->validate([
            'image' => 'required|image|mimes:png|max:5120'
        ]);
        
        // Get uploaded file
        $imageFile = $request->file('image');

        // Initialize image manager (using GD driver)
        $manager = new ImageManager(new Driver());
        $image = $manager->read($imageFile->getPathname());
        
        $compressedName = time() . '.jpg';
        $finalPath = 'tools/convertImage/' . $compressedName;
        
        Storage::disk('public')->put($finalPath, $image->toJpeg());

        // Return JSON response
        $response = [
            'path' => Storage::url($finalPath)
        ];

        return back()->with($response);
    }

    public function convertImageToPdf(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('tools.image-to-pdf');
        }
    
        $request->validate([
            'image' => 'required|image|mimes:png,jpg,jpeg|max:5120'
        ]);

        // Get uploaded image
        $image = $request->file('image');
        $imagePath = $image->store('tools/', 'public');
        $imageUrl = storage_path('app/public/' . $imagePath);

        // Generate raw HTML with embedded image URL
        $html = '
                <!DOCTYPE html>
                <html>
                <head>
                    <style>
                        body {
                            text-align: center;
                            margin: 0;
                            padding: 0;
                        }
                        img {
                            max-width: 100%;
                            height: auto;
                            margin-top: 20px;
                        }
                    </style>
                </head>
                <body>
                    <img src="' . $imageUrl . '" alt="Converted Image">
                </body>
                </html>
            ';

        // Generate PDF from Blade view with image
        $pdf = Pdf::loadHTML($html);
        $fileName = time() . '.pdf';
        $pdfPath = 'tools/pdf/' . $fileName;
        Storage::disk('public')->put($pdfPath, $pdf->output());
        
        // Delete temp image after generating PDF
        Storage::disk('public')->delete($imagePath);

        return back()->with([
            'path' => Storage::url($pdfPath),
        ]);

    }
}
