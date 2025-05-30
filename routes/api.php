<?php
Route::get('/test', function () {
    return response()->json(['message' => 'API çalışıyor!']);
});

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EducationController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;

Route::apiResource('educations', EducationController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('tags', TagController::class);

