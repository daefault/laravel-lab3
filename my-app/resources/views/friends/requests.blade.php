@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Запросы в друзья</span>
                    <a href="{{ route('friends.index') }}" class="btn btn-outline-secondary btn-sm">
                        К списку друзей
                    </a>
                </div>

                <div class="card-body">
                    @if($pendingRequests->count() > 0)
                        <div class="list-group">
                            @foreach($pendingRequests as $request)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('users.characters', $request->user) }}" 
                                               class="text-decoration-none fw-bold">
                                                {{ $request->user->name }}
                                            </a>
                                            <small class="text-muted d-block">
                                                @ {{ $request->user->username }}
                                            </small>
                                            <small class="text-muted">
                                                Запрос отправлен: {{ $request->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        
                                        <div class="btn-group" role="group">
                                            <form action="{{ route('friends.accept', $request->user) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-sm">
                                                    Принять
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('friends.reject', $request->user) }}" 
                                                  method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    Отклонить
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            У вас нет ожидающих запросов в друзья.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection