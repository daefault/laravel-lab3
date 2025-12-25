<?php

namespace App\Http\Controllers;

use App\Models\Friendship;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Character;

class FriendshipController extends Controller
{
    public function sendRequest(User $user)
    {
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'Нельзя отправить запрос дружбы самому себе');
        }


        $existingRequest = Friendship::where(function ($query) use ($user) {
            $query->where('user_id', Auth::id())
                  ->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', Auth::id());
        })->first();

        if ($existingRequest) {
            return redirect()->back()->with('info', 'Запрос дружбы уже существует');
        }


        $friendship = Friendship::create([
        'user_id' => Auth::id(),
        'friend_id' => $user->id,
        'status' => 'pending'
    ]);
    
    // Проверяем, не отправил ли второй пользователь запрос раньше
    $reverseRequest = Friendship::where('user_id', $user->id)
        ->where('friend_id', Auth::id())
        ->where('status', 'pending')
        ->first();
    
    if ($reverseRequest) {
        // АВТОМАТИЧЕСКАЯ ДВУСТОРОННЯЯ ДРУЖБА
        $friendship->update(['status' => 'accepted']);
        $reverseRequest->update(['status' => 'accepted']);
        
        return redirect()->back()->with('success', 'Дружба установлена!');
    }
    
    return redirect()->back()->with('success', 'Запрос дружбы отправлен!');
    }


    public function acceptRequest(User $user)
    {

        $requestToMe = Friendship::where('user_id', $user->id)
            ->where('friend_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        $myRequest = Friendship::where('user_id', Auth::id())
            ->where('friend_id', $user->id)
            ->where('status', 'pending')
            ->first();

        if ($requestToMe) {
            $requestToMe->update(['status' => 'accepted']);
        }

        if ($myRequest) {
            $myRequest->update(['status' => 'accepted']);
        }

        return redirect()->back()->with('success', 'Запрос дружбы принят!');
    }

    public function rejectRequest(User $user)
    {

        Friendship::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', Auth::id());
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', Auth::id())
                  ->where('friend_id', $user->id);
        })->delete();

        return redirect()->back()->with('success', 'Запрос дружбы отклонен');
    }

    public function removeFriend(User $user)
    {
        Friendship::where(function ($query) use ($user) {
            $query->where('user_id', Auth::id())
                  ->where('friend_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('friend_id', Auth::id());
        })->delete();

        return redirect()->back()->with('success', 'Друг удален');
    }


    public function friends()
    {
        $user = Auth::user();
        $friends = $user->allFriends();
        
        return view('friends.index', compact('friends', 'user'));
    }

    public function requests()
    {
        $pendingRequests = Auth::user()->receivedFriendRequests()
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('friends.requests', compact('pendingRequests'));
    }

    public function feed()
    {
        $user = Auth::user();
        
        $friendIds = $user->allFriends()->pluck('id')->toArray();
        
        $friendIds[] = $user->id;
        
        $characters = Character::whereIn('user_id', $friendIds)
            ->with('user', 'comments')
            ->latest()
            ->paginate(10);
        
        return view('friends.feed', compact('characters'));
    }
}