@extends('layouts.app')

@section('title', 'Редактировать ' . $character->name)

@section('styles')
<style>
    .edit-form-container {
        min-height: 500px;
    }
</style>
@endsection

@section('content')
<div class="container my-4 edit-form-container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-header">
                    <h4>Редактировать персонажа: {{ $character->name }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('characters.update', $character) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Имя персонажа *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $character->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Путь к изображению *</label>
                            <input type="text" class="form-control @error('image') is-invalid @enderror" id="image"
                                name="image" value="{{ old('image', $character->image) }}"
                                placeholder="/images/spongebob.jpg" required>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Примеры: /images/spongebob.jpg, /images/patrick.jpg
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="type" class="form-label">Тип персонажа *</label>
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type"
                                required>
                                <option value="">Выберите тип</option>
                                <option value="морская губка" {{ old('type', $character->getRawOriginal('type')) == 'морская губка' ? 'selected' : '' }}>
                                    Морская губка
                                </option>
                                <option value="морская звезда" {{ old('type', $character->getRawOriginal('type')) == 'морская звезда' ? 'selected' : '' }}>
                                    Морская звезда
                                </option>
                                <option value="краб" {{ old('type', $character->getRawOriginal('type')) == 'краб' ? 'selected' : '' }}>
                                    Краб
                                </option>
                                <option value="кальмар" {{ old('type', $character->getRawOriginal('type')) == 'кальмар' ? 'selected' : '' }}>
                                    Кальмар
                                </option>
                                <option value="белка" {{ old('type', $character->getRawOriginal('type')) == 'белка' ? 'selected' : '' }}>
                                    Белка
                                </option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="7"
                                required>{{ old('description', $character->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-warning">Обновить персонажа</button>
                            <a href="{{ route('characters.show', $character) }}"
                                class="btn btn-secondary">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection