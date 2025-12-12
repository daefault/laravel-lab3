<?php

use App\Models\Character;
use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $characters = Character::all();
    return view('welcome', compact('characters'));
});

Route::resource('characters', CharacterController::class)->except(['index']);