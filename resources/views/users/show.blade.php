@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-user"></i> {{ $user->name }}'s Profile</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong><i class="fas fa-envelope"></i> Email:</strong> {{ $user->email }}</p>
                        @if($user->phone)
                        <p><strong><i class="fas fa-phone"></i> Phone:</strong> {{ $user->phone }}</p>
                        @endif
                        @if($user->location)
                        <p><strong><i class="fas fa-map-marker-alt"></i> Location:</strong> {{ $user->location }}</p>
                        @endif
                        @if($user->bio)
                        <p><strong><i class="fas fa-info-circle"></i> Bio:</strong> {{ $user->bio }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Liked Dogs -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-heart"></i> {{ $user->name }}'s Liked Dog Breeds</h4>
            </div>
            <div class="card-body">
                @if($user->likedDogs->count() > 0)
                <div class="row">
                    @foreach($user->likedDogs as $likedDog)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="{{ $likedDog->image_url }}" class="card-img-top dog-image" alt="{{ $likedDog->breed_name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ ucfirst($likedDog->breed_name) }}</h5>
                                <small class="text-muted">Liked on {{ $likedDog->created_at->format('M j, Y') }}</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle"></i> This user hasn't liked any dog breeds yet.
                </div>
                @endif
            </div>
        </div>

        <div class="mt-3">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>
</div>
@endsection