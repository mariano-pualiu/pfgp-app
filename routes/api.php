<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('mofs/{cif_file}', function ($cif_file) {
        return response()->file(Storage::path("pfgp/mofs/{$cif_file}"));
    });

    Route::get('download/mofs/{cif_file}', function ($cif_file) {
        return response()->download(Storage::path("app/pfgp/mofs/{$cif_file}"));
    });

    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

