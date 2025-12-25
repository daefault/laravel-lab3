@auth
    <form action="{{ route('comments.store', $character) }}" method="POST" class="mt-4">
        @csrf
        
        <div class="mb-3">
            <label for="content" class="form-label">Добавить комментарий:</label>
            <textarea 
                name="content" 
                id="content" 
                rows="3" 
                class="form-control @error('content') is-invalid @enderror"
                placeholder="Напишите ваш комментарий..."
                required
            >{{ old('content') }}</textarea>
            
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Отправить</button>
    </form>
@else
    <div class="alert alert-info mt-4">
        <a href="{{ route('login') }}">Войдите</a>, чтобы оставлять комментарии.
    </div>
@endauth