<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Request $request, Character $character)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        $comment = Comment::create([
            'content' => $validated['content'],
            'user_id' => Auth::id(),
            'character_id' => $character->id,
        ]);

        return redirect()->route('characters.show', $character)
            ->with('success', 'Комментарий успешно добавлен!');
    }


    public function edit(Comment $comment)
    {
        if (!Gate::allows('update-comment', $comment)) {
            abort(403, 'У вас нет прав на редактирование этого комментария');
        }

        return view('comments.edit', compact('comment'));
    }


    public function update(Request $request, Comment $comment)
    {
        if (!Gate::allows('update-comment', $comment)) {
            abort(403, 'У вас нет прав на редактирование этого комментария');
        }

        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
        ]);

        $comment->update($validated);

        return redirect()->route('characters.show', $comment->character)
            ->with('success', 'Комментарий успешно обновлен!');
    }

    public function destroy(Comment $comment)
    {
        if (!Gate::allows('delete-comment', $comment)) {
            abort(403, 'У вас нет прав на удаление этого комментария');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Комментарий удален!');
    }


    public function restore($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        
        if (!Gate::allows('restore-comment', $comment)) {
            abort(403, 'Только администратор может восстанавливать комментарии');
        }

        $comment->restore();

        return redirect()->back()->with('success', 'Комментарий восстановлен!');
    }

    public function forceDelete($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        
        if (!Gate::allows('force-delete-comment', $comment)) {
            abort(403, 'Только администратор может полностью удалять комментарии');
        }

        $comment->forceDelete();

        return redirect()->back()->with('success', 'Комментарий полностью удален!');
    }
}