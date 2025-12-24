@extends('layouts.app')

@section('title', 'Лабораторная работа 4')

@section('content')

    <div class="container my-4">
        <h1 class="text-center mb-4 text-primary">Персонажи и их описание</h1>
        <div class="row g-4">
            @foreach($characters as $character)
                <div class="col-12 col-xs-12 col-sm-6 col-md-6 col col-lg-4 col-xl-3 col-xxl-3 col-xxxl-2">
                    <div class="card card-custom-{{ ($loop->iteration - 1) % 5 + 1 }} character-card h-100">
                        <div class="position-relative">
                            <img src="{{ $character->image }}" alt="{{ $character->name }}"
                                class="card-img-top img-fluid character-image">
                            <span class="character-label">{{ $character->type }}</span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $character->name }}</h5>
                            <p class="card-text">
                                <small class="text-muted">
                                    Владелец: 
                                        @if($character->user)
                                            <a href="{{ route('users.characters', $character->user->username) }}" 
                                                class="text-decoration-none">
                                                {{ $character->user->name }}
                                            </a>
                                        @else
                                            <span class="text-muted">Неизвестно</span>
                                        @endif
                                </small>
                            </p>
                            <p class="card-text">{{ Str::limit($character->description, 100) }}</p>
                            <a href="{{ route('characters.show', $character) }}"
                                class="btn btn-outline-primary mt-auto">Подробнее</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection