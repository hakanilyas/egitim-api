<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/educations', function () {
    return view('educations.index');
})->name('educations.index');

Route::get('/categories', function () {
    return view('categories.index');
})->name('categories.index');

Route::get('/tags', function () {
    return view('tags.index');
})->name('tags.index');
