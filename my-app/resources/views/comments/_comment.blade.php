@php
    $isFriend = auth()->check() && in_array($comment->user_id, $friendIds ?? []);
@endphp

<div class="card mb-3 comment-card {{ $isFriend ? 'friend-comment' : '' }}" 
     style="{{ $isFriend ? 'border-left: 4px solid #0d6efd; background-color: rgba(13, 110, 253, 0.05);' : '' }}">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h6 class="card-subtitle mb-2 text-muted">
                    <a href="{{ route('users.characters', $comment->user) }}" class="text-decoration-none">
                        {{ $comment->user->name }}
                        @if($isFriend)
                            <span class="badge bg-primary ms-1">
                                <i class="fas fa-user-friends"></i> Друг
                            </span>
                        @endif
                    </a>
                    <small class="text-muted">
                        • {{ $comment->created_at->diffForHumans() }}
                    </small>
                </h6>
            </div>
            
            @auth
                @if(Gate::allows('update-comment', $comment) || Gate::allows('delete-comment', $comment))
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary" type="button" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            ⋮
                        </button>
                        <ul class="dropdown-menu">
                            @if(Gate::allows('update-comment', $comment))
                                <li>
                                    <a class="dropdown-item" 
                                       href="{{ route('comments.edit', $comment) }}">
                                        Редактировать
                                    </a>
                                </li>
                            @endif
                            @if(Gate::allows('delete-comment', $comment))
                                <li>
                                    <form action="{{ route('comments.destroy', $comment) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger"
                                                onclick="return confirm('Удалить комментарий?')">
                                            Удалить
                                        </button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </div>
                @endif
            @endauth
        </div>
        
        <p class="card-text {{ $isFriend ? 'fw-medium' : '' }}">
            @if($isFriend)
                <i class="fas fa-star text-warning me-1"></i>
            @endif
            {{ $comment->content }}
        </p>
        
        @if($comment->deleted_at)
            <small class="text-danger">
                <i>Комментарий удален {{ $comment->deleted_at->diffForHumans() }}</i>
            </small>
        @endif
    </div>
</div>