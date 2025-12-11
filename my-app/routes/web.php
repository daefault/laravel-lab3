<?php

use App\Models\character;
use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $characters = character::all();
    return view('welcome', compact('characters'));
});

Route::resource('characters', CharacterController::class)->except(['index']);