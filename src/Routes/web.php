<?php

use Illuminate\Support\Facades\Route;
use Toaha\UsCitiesAdmin\Http\Controllers\UsCitiesFileUploadController;

Route::prefix('uscities')->middleware(['web'])->group(function () {
    Route::view('/', 'uscitiesadmin::dashboard');

    Route::group(['prefix' => 'file-upload', 'as' => 'file_upload.'], function () {
        Route::get('/', [UsCitiesFileUploadController::class, 'index'])->name('index');
        Route::get('/import', [UsCitiesFileUploadController::class, 'import'])->name('import');
    });

});
