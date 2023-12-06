<?php

use Illuminate\Support\Facades\Route;
use Toaha\UsCitiesAdmin\Http\Controllers\Api\UsCitiesFileUploadApiController;

Route::prefix('/api/uscities')->middleware(["web"])->group(function (){
    Route::post('/fie-upload', [UsCitiesFileUploadApiController::class, 'file_upload']); 
    Route::get('/get-cities-data', [UsCitiesFileUploadApiController::class, 'get_cities_data']); 
    Route::get('/get-city-data', [UsCitiesFileUploadApiController::class, 'get_city_data']); 
    
    Route::get('/cities-api-data', [UsCitiesFileUploadApiController::class, 'citiesApiData']); 
});