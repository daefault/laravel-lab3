@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Редактирование комментария</div>

                <div class="card-body">
                    <form action="{{ route('comments.update', $comment) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="content" class="form-label">Комментарий:</label>
                            <textarea 
                                name="content" 
                                id="content" 
                                rows="5" 
                                class="form-control @error('content') is-invalid @enderror"
                                required
                            >{{ old('content', $comment->content) }}</textarea>
                            
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('characters.show', $comment->character) }}" class="btn btn-secondary">
                                Отмена
                            </a>
                            <button type="submit" class="btn btn-primary">Обновить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection