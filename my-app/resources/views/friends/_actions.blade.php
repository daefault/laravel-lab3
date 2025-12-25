@auth
    @if(auth()->id() !== $user->id)
        <div class="mt-3">
            @if(auth()->user()->isFriendWith($user))
                <form action="{{ route('friends.remove', $user) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger btn-sm"
                            onclick="return confirm('Удалить из друзей?')">
                        Удалить из друзей
                    </button>
                </form>
            @elseif(auth()->user()->hasSentFriendRequestTo($user))
                <button class="btn btn-outline-secondary btn-sm" disabled>
                    Запрос отправлен
                </button>
                
                <form action="{{ route('friends.reject', $user) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        Отменить запрос
                    </button>
                </form>
            @elseif(auth()->user()->hasReceivedFriendRequestFrom($user))
                <form action="{{ route('friends.accept', $user) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">
                        Принять запрос
                    </button>
                </form>
                
                <form action="{{ route('friends.reject', $user) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">
                        Отклонить
                    </button>
                </form>
            @else
                <form action="{{ route('friends.send', $user) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">
                        Добавить в друзья
                    </button>
                </form>
            @endif
        </div>
    @endif
@endauth