<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Character;
use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Gate;


Route::get('/my-characters', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }

    $characters = auth()->user()->characters()->get();
    return view('characters.my', compact('characters'));
})->middleware('auth')->name('characters.my');

Route::get('/', function () {
    $characters = Character::all();
    return view('welcome', compact('characters'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}/characters', function ($identifier) {
    $user = \App\Models\User::where('username', $identifier)->first();
    
    if (!$user) {
        $user = \App\Models\User::find($identifier);
    }
    
    if (!$user) {
        abort(404, 'Пользователь не найден');
    }
    
    $characters = $user->characters()->get();
    return view('users.characters', [
        'user' => $user,
        'characters' => $characters
    ]);
})->name('users.characters');

    Route::resource('characters', CharacterController::class)->except(['index']);
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        Route::get('/trash', function () {
            if (!Gate::allows('view-trash', auth()->user())) {
                abort(403, 'Доступ запрещен');
            }
            $characters = Character::onlyTrashed()->with('user')->get();
            return view('admin.trash', compact('characters'));
        })->name('trash');

        Route::put('/characters/{id}/restore', [CharacterController::class, 'restore'])
            ->name('characters.restore');

        Route::delete('/characters/{id}/force-delete', [CharacterController::class, 'forceDelete'])
            ->name('characters.forceDelete');
    });
});
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
