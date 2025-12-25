<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CharacterController extends Controller
{
    public function create()
    {
        return view('characters.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $character = Character::create([
            'name' => $validated['name'],
            'image' => $validated['image'],
            'type' => $validated['type'],
            'description' => $validated['description'],
            'user_id' => auth()->id()
        ]);
        return redirect('/')
            ->with('success', 'Персонаж успешно создан!');
    }

public function show(Character $character)
{
    $friendIds = auth()->check() 
        ? auth()->user()->allFriends()->pluck('id')->toArray()
        : [];
    
    $comments = $character->comments()
        ->with('user')
        ->latest()
        ->get();
    
    return view('characters.show', compact('character', 'comments', 'friendIds'));
}
    public function edit(Character $character)
    {
        if (!Gate::allows('update-character', $character)) {
            abort(403, 'У вас нет прав на редактирование этого персонажа');
        }
        return view('characters.edit', compact('character'));
    }

    public function update(Request $request, Character $character)
    {
        if (!Gate::allows('update-character', $character)) {
            abort(403, 'У вас нет прав на редактирование этого персонажа');
        }
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $character->name = $validated['name'];
        $character->type = $validated['type'];
        $character->image = $validated['image'];
        $character->description = $validated['description'];
        $character->save();

        return redirect()->route('characters.show', $character)
            ->with('success', 'Персонаж успешно обновлен!');
    }

    public function destroy(Character $character)
    {
        if (!Gate::allows('delete-character', $character)) {
            abort(403, 'У вас нет прав на удаление этого персонажа');
        }

        $character->delete();

        return redirect('/')->with('success', 'Персонаж перемещен в корзину!');
    }
    public function restore($id)
    {
        $user = auth()->user();
        
        if (!Gate::allows('restore-character', $user)) {
            abort(403, 'Только администратор может восстанавливать персонажей');
        }
        $character = Character::withTrashed()->findOrFail($id);

        
        $character->restore();

        return redirect()->back()->with('success', 'Персонаж восстановлен!');
    }
    public function forceDelete($id)
    {
        $user = auth()->user();
        
        if (!Gate::allows('force-delete-character', $user)) {
            abort(403, 'Только администратор может полностью удалять персонажей');
        }
        $character = Character::withTrashed()->findOrFail($id);

        $character->forceDelete();

        return redirect()->back()->with('success', 'Персонаж полностью удален!');
    }
}