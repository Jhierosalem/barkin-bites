@extends('layouts.app')

@section('title', 'All Users')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4"><i class="fas fa-users"></i> All Users</h1>
        
        <div class="row">
            @foreach($users as $user)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $user->name }}</h5>
                        <p class="card-text">
                            <i class="fas fa-envelope"></i> {{ $user->email }}<br>
                            @if($user->location)
                                <i class="fas fa-map-marker-alt"></i> {{ $user->location }}<br>
                            @endif
                            <i class="fas fa-heart"></i> {{ $user->liked_dogs_count }} liked dog breeds
                        </p>
                        <a href="{{ route('users.show', $user) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-eye"></i> View Profile
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        @if($users->isEmpty())
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No other users found.
        </div>
        @endif
    </div>
</div>
@endsection