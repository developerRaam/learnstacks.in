<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Tools\PasswordGenerator;
use App\Http\Controllers\Frontend\Tools\ResumeBuilderController;

Route::name('tools')->prefix('tools')->group(function () {
    route::get('password-generator', [PasswordGenerator::class, 'passwordGenerator'])->name('passwordGenerator');
    
    Route::get('/resume-builder', [ResumeBuilderController::class, 'index'])->name('resumeBuilder');
    Route::post('/generate-resume', [ResumeBuilderController::class, 'resumeBuilder']);
});