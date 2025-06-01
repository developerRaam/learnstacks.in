<?php

use App\Http\Controllers\Tools\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tools\PasswordGenerator;
use App\Http\Controllers\Tools\PdfController;
use App\Http\Controllers\Tools\ResumeBuilderController;
use App\Http\Controllers\Tools\ToolsController;

Route::name('tools.')->prefix('tools')->group(function () {
    Route::get('/', [ToolsController::class, 'tools'])->name('tools');
    route::get('password-generator', [PasswordGenerator::class, 'passwordGenerator'])->name('passwordGenerator');
    
    Route::get('/resume-builder', [ResumeBuilderController::class, 'index'])->name('resumeBuilder');
    Route::post('/generate-resume', [ResumeBuilderController::class, 'resumeBuilder']);
    
    Route::match(['get', 'post'],'/image-compressor', [ImageController::class, 'imageCompress'])->name('imageCompress');
    Route::match(['get', 'post'], '/jpg-to-png', [ImageController::class, 'convertJpgToPng'])->name('convertJpgToPng');
    Route::match(['get', 'post'], '/png-to-jpg', [ImageController::class, 'convertPngToJpg'])->name('convertPngToJpg');
    Route::match(['get', 'post'], '/image-to-pdf', [ImageController::class, 'convertImageToPdf'])->name('convertImageToPdf');
    Route::match(['get', 'post'], '/webp-to-jpg', [ImageController::class, 'convertWebpToJpg'])->name('convertWebpToJpg');
    Route::match(['get', 'post'], '/remove-background', [ImageController::class, 'removeBackground'])->name('removeBackground');
    Route::match(['get', 'post'], '/image-resize', [ImageController::class, 'imageResize'])->name('imageResize');

    Route::match(['get', 'post'], '/pdf-to-jpg', [PdfController::class, 'convertPdfToJpg'])->name('convertPdfToJpg');
    Route::match(['get', 'post'], '/pdf-merge', [PdfController::class, 'pdfMerge'])->name('pdfMerge');
});


