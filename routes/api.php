<?php

use App\Http\Controllers\FilesController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return 'test';
});
Route::prefix('v1')->group(function () {
    Route::resource('files', FilesController::class);
});
