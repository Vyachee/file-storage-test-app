<?php

use App\Http\Controllers\FilesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'test';
});
Route::prefix('v1')->group(function () {
    Route::prefix('files')->controller(FilesController::class)->group(function() {
       Route::get('/', 'index');
       Route::post('/', 'store');
       Route::post('/{id}', 'update');
       Route::delete('/{id}', 'destroy');
    });
});
