@extends('layouts.app')

@section('title', 'Добавить персонажа')

@section('styles')
<style>
    /* Стили для прижатия футера к низу */
    html, body {
        height: 100%;
        margin: 0;
    }
    
    body {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }
    
    main {
        flex: 1; /* Занимает всё доступное пространство */
    }
    
    .create-form-container {
        min-height: 500px; /* Минимальная высота для формы */
    }
</style>
@endsection

@section('content')
<div class="container my-4 create-form-container">
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
                    <h4>Добавить нового персонажа</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('characters.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Имя персонажа *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Путь к изображению *</label>
                            <input type="text" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" value="{{ old('image') }}" 
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
                            <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="">Выберите тип</option>
                                <option value="морская губка" {{ old('type') == 'морская губка' ? 'selected' : '' }}>Морская губка</option>
                                <option value="морская звезда" {{ old('type') == 'морская звезда' ? 'selected' : '' }}>Морская звезда</option>
                                <option value="краб" {{ old('type') == 'краб' ? 'selected' : '' }}>Краб</option>
                                <option value="кальмар" {{ old('type') == 'кальмар' ? 'selected' : '' }}>Кальмар</option>
                                <option value="белка" {{ old('type') == 'белка' ? 'selected' : '' }}>Белка</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание *</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="7" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-success">Создать персонажа</button>
                            <a href="/" class="btn btn-secondary">Отмена</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection