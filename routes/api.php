<?php

use App\Models\Material;
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

// Route::get('mofs/{cif_file}', function ($cif_file) {
//     return response()->file(Storage::path("pfgp/mofs/{$cif_file}"));
// });

// Route::get('download/mofs/{node}/{linker}', function ($node, $linker) {
//     $cifFile = "ums_{$node}_{$linker}_opt.cif";

//     return response()->download(Storage::path("pfgp/mofs/{$cifFile}"));
// })->name('download.mof.cif');


Route::get('materials/{material}.cif', function (Material $material) {
    return $material->getFirstMedia('cif-files');
    // return response()->file(Storage::path("pfgp/mofs/{$material_id}"));
});

Route::get('download/materials/{material}/cif', function (Material $material) {
    $cifFile = "ums_{$node}_{$linker}_opt.cif";

    return response()->download(Storage::path("pfgp/mofs/{$cifFile}"));
})->name('download.material.cif');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

