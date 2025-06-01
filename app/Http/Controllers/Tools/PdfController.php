<?php

namespace App\Http\Controllers\Tools;

use setasign\Fpdi\Fpdi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\PdfToImage\Pdf;
use Illuminate\Support\Facades\Storage;


class PdfController extends Controller
{
    public function convertPdfToJpg(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('tools.pdf-to-jpg');
        }
    
        $request->validate([
            'pdf' => 'required|mimes:pdf|max:10240', // 10MB limit
        ]);
    
        $pdf = $request->file('pdf');
        $pdfPath = $pdf->store('tools/pdf', 'public');
        $pdfFullPath = storage_path('app/public/' . $pdfPath);
    
        $pdf = new Pdf($pdfFullPath);
        // Make sure directory exists
        Storage::disk('public')->makeDirectory('tools/convertImage');
        // Output JPG filename
        $jpgFileName = time() . '.jpg';
        $jpgFullPath = storage_path('app/public/tools/convertImage/' . $jpgFileName);
        $pdf->save($jpgFullPath);
    
        return back()->with([
            'path' => Storage::url('tools/convertImage/' . $jpgFileName),
        ]);
    }

    public function pdfMerge(Request $request){
        if ($request->isMethod('get')) {
            return view('tools.pdf-merge');
        }
    
        $request->validate([
            'pdfs' => 'required|array',
            'pdfs.*' => 'mimes:pdf|max:10240', // each file 10MB limit
        ]);
    
        $files = $request->file('pdfs');

        dd($files);

        $mergedPdf = new Fpdi();
    
        foreach ($files as $file) {
            $path = $file->store('tools/temp', 'public');
            $fullPath = storage_path('app/public/' . $path);
    
            $pageCount = $mergedPdf->setSourceFile($fullPath);
    
            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $templateId = $mergedPdf->importPage($pageNo);
                $size = $mergedPdf->getTemplateSize($templateId);
    
                $mergedPdf->AddPage($size['orientation'], [$size['width'], $size['height']]);
                $mergedPdf->useTemplate($templateId);
            }
        }
    
        $mergedFileName = 'merged_' . time() . '.pdf';
        $mergedPath = storage_path('app/public/tools/pdf/' . $mergedFileName);
    
        // Output merged PDF
        $mergedPdf->Output($mergedPath, 'F');
    
        return back()->with([
            'path' => Storage::url('tools/pdf/' . $mergedFileName),
        ]);

    }
}
