@extends('layouts.app')

@section('title', $character->name . ' - Детальная информация')

@section('styles')
    <style>
        .character-details {
            min-height: 400px;
        }

        .character-detail-image {
            max-height: 400px;
            object-fit: cover;
        }
    </style>
@endsection

@section('content')
    <div class="container my-4 character-details">
        <div class="row">
            <div class="col-md-6">
                <div class="text-center mb-4">
                    <img src="{{ $character->image }}" alt="{{ $character->name }}"
                        class="img-fluid rounded character-detail-image">
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-body">
                        <h1 class="card-title">{{ $character->name }}</h1>
                        <p class="text-muted fs-5">Тип: <span class="badge bg-primary">{{ $character->type }}</span></p>

                        <div class="character-description mt-4">
                            <h4>Описание:</h4>
                            <p class="fs-5">{{ $character->description }}</p>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            @auth
                                @can('update-character', $character)
                                    <a href="{{ route('characters.edit', $character) }}" class="btn btn-warning">Редактировать</a>
                                @endcan
                                @can('delete-character', $character)
                                    <form action="{{ route('characters.destroy', $character) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger"
                                            onclick="return confirm('Удалить персонажа?')">Удалить</button>
                                    </form>
                                @endcan
                            @endauth
                            <a href="/" class="btn btn-secondary">На главную</a>
                        </div>

                        <div class="mt-4 pt-3 border-top">
                            <small class="text-muted">
                                <i class="fas fa-calendar-alt"></i> Создан:
                                {{ $character->created_at->format('d.m.Y H:i') }}<br>
                                <i class="fas fa-history"></i> Обновлен:
                                {{ $character->updated_at->format('d.m.Y H:i') }}<br>
                                <i class="fas fa-user"></i> Владелец:
                                @if($character->user)
        <a href="{{ route('users.characters', $character->user->username) }}">
            {{ $character->user->name }}
        </a>
    @else
        Неизвестно
    @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection