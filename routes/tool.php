<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::name('tool')->prefix('tool')->group(function () {
    route::get('/', function(){
        return 'tool';
    });
});