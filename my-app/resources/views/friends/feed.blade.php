@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Лента друзей</span>
                    <div>
                        <a href="{{ route('friends.index') }}" class="btn btn-outline-secondary btn-sm">
                            К списку друзей
                        </a>
                        <a href="{{ route('friends.requests') }}" class="btn btn-outline-primary btn-sm ms-2">
                            Запросы в друзья
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($characters->count() > 0)
                        @foreach($characters as $character)
                            <div class="card mb-4">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ route('users.characters', $character->user) }}" 
                                           class="text-decoration-none fw-bold">
                                            {{ $character->user->name }}
                                        </a>
                                        <small class="text-muted ms-2">
                                            @ {{ $character->user->username }}
                                        </small>
                                        @if(auth()->user()->isFriendWith($character->user))
                                            <span class="badge bg-primary ms-2">Друг</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        {{ $character->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('characters.show', $character) }}" 
                                           class="text-decoration-none">
                                            {{ $character->name }}
                                        </a>
                                    </h5>
                                    <h6 class="card-subtitle mb-2 text-muted">
                                        Тип: {{ $character->type }}
                                    </h6>
                                    
                                    @if($character->image)
                                        <div class="mb-3">
                                            <img src="{{ $character->image }}" 
                                                 alt="{{ $character->name }}" 
                                                 class="img-fluid rounded" 
                                                 style="max-height: 300px;">
                                        </div>
                                    @endif
                                    
                                    <p class="card-text">{{ Str::limit($character->description, 200) }}</p>
                                    
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <a href="{{ route('characters.show', $character) }}" 
                                           class="btn btn-outline-primary btn-sm">
                                            Подробнее
                                        </a>
                                        <small class="text-muted">
                                            Комментариев: {{ $character->comments->count() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        <!-- Пагинация -->
                        <div class="d-flex justify-content-center">
                            {{ $characters->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            В ленте пока нет записей. Добавьте друзей, чтобы видеть их персонажей!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection