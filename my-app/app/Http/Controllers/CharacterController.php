<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

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

        $character = new Character();
        $character->setAttribute('name', $validated['name']);
        $character->setAttribute('image', $validated['image']);
        $character->setAttribute('type', $validated['type']);
        $character->setAttribute('description', $validated['description']);
        $character->save();

        return redirect('/')
            ->with('success', 'Персонаж успешно создан!');
    }

    public function show(Character $character)
    {
        return view('characters.show', compact('character'));
    }

    public function edit(Character $character)
    {
        return view('characters.edit', compact('character'));
    }

    public function update(Request $request, Character $character)
    {
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
        $character->delete();
        return redirect('/')
            ->with('success', 'Персонаж успешно удален!');
    }
}