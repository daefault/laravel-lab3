@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Мои друзья ({{ $friends->count() }})</span>
                    <div>
                        <a href="{{ route('friends.requests') }}" class="btn btn-outline-primary btn-sm">
                            Запросы в друзья
                            @if(auth()->user()->receivedFriendRequests()->where('status', 'pending')->count() > 0)
                                <span class="badge bg-danger">
                                    {{ auth()->user()->receivedFriendRequests()->where('status', 'pending')->count() }}
                                </span>
                            @endif
                        </a>
                        <a href="{{ route('friends.feed') }}" class="btn btn-outline-success btn-sm ms-2">
                            Лента друзей
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($friends->count() > 0)
                        <div class="list-group">
                            @foreach($friends as $friend)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ route('users.characters', $friend) }}" 
                                           class="text-decoration-none fw-bold">
                                            {{ $friend->name }}
                                        </a>
                                        <small class="text-muted d-block">
                                            @ {{ $friend->username }}
                                        </small>
                                    </div>
                                    
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('users.characters', $friend) }}" 
                                           class="btn btn-outline-info btn-sm">
                                            Персонажи
                                        </a>
                                        <form action="{{ route('friends.remove', $friend) }}" 
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirm('Удалить из друзей?')">
                                                Удалить
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            У вас пока нет друзей. Найдите других пользователей и отправьте им запросы!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection