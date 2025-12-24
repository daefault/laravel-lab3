@extends('layouts.app')

@section('title', 'Мои персонажи')

@section('content')
<div class="container">
    <h1>Мои персонажи</h1>
    
    @if($characters->isEmpty())
        <div class="alert alert-info">
            У вас пока нет персонажей. 
            <a href="{{ route('characters.create') }}">Создайте первого!</a>
        </div>
    @else
        <div class="row">
            @foreach($characters as $character)
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="{{ $character->image }}" class="card-img-top" alt="{{ $character->name }}" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $character->name }}</h5>
                            <p class="card-text">{{ Str::limit($character->description, 100) }}</p>
                            <p class="card-text"><small class="text-muted">{{ $character->type }}</small></p>
                            
                            <div class="btn-group">
                                <a href="{{ route('characters.show', $character) }}" class="btn btn-sm btn-info">
                                    Подробнее
                                </a>
                                <a href="{{ route('characters.edit', $character) }}" class="btn btn-sm btn-warning">
                                    Редактировать
                                </a>
                                <form action="{{ route('characters.destroy', $character) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить?')">
                                        Удалить
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    
    <a href="{{ route('characters.create') }}" class="btn btn-primary mt-3">
        Добавить нового персонажа
    </a>
</div>
@endsection