<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Barkin Bites</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .dog-card {
            transition: transform 0.2s;
            height: 100%;
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .dog-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.1);
        }
        .dog-image {
            height: 250px;
            object-fit: cover;
            width: 100%;
        }
        .liked-dogs-section {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 0;
            margin-bottom: 30px;
            border-radius: 10px;
        }
        .breed-counter {
            background: white;
            color: #333;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: bold;
            display: inline-block;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-paw"></i> Barkin Bites
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('dashboard') }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="fas fa-users"></i> Users
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('profile.edit') }}">
                            <i class="fas fa-user"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-outline-light btn-sm">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div class="container">
            <!-- Welcome Section -->
            <div class="welcome-section text-center">
                <div class="row">
                    <div class="col-12">
                        <h1 class="display-4 mb-3">
                            <i class="fas fa-paw"></i> Welcome to Barkin Bites!
                        </h1>
                        <p class="lead mb-4">Discover amazing dog breeds and choose your favorites</p>
                        <div class="breed-counter">
                            <i class="fas fa-dog me-2"></i> {{ count($breedsWithImages) }} Breeds Available
                        </div>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- User's Liked Dogs Section -->
            @if($userLikedDogs->count() > 0)
            <div class="liked-dogs-section">
                <div class="row">
                    <div class="col-12">
                        <h3 class="mb-4">
                            <i class="fas fa-heart text-danger me-2"></i> 
                            Your Favorite Dog Breeds 
                            <span class="badge bg-dark ms-2">{{ $userLikedDogs->count() }}/3</span>
                        </h3>
                    </div>
                </div>
                <div class="row">
                    @foreach($userLikedDogs as $likedDog)
                    <div class="col-md-4 mb-3">
                        <div class="card dog-card">
                            <img src="{{ $likedDog->image_url }}" class="card-img-top dog-image" alt="{{ $likedDog->breed_name }}" 
                                 onerror="this.src='https://via.placeholder.com/300x200/667eea/ffffff?text=No+Image'">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ ucfirst($likedDog->breed_name) }}</h5>
                                <button class="btn btn-danger btn-sm unlike-btn" data-id="{{ $likedDog->id }}">
                                    <i class="fas fa-heart-broken me-1"></i> Unlike
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Available Dog Breeds Section -->
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-dog me-2"></i> Available Dog Breeds
                        @if($userLikedDogs->count() >= 3)
                        <span class="badge bg-warning text-dark ms-2">Limit Reached (3/3)</span>
                        @else
                        <span class="badge bg-light text-dark ms-2">{{ $userLikedDogs->count() }}/3 Liked</span>
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    @if(isset($breedsWithImages) && count($breedsWithImages) > 0)
                    <div class="row">
                        @foreach($breedsWithImages as $breed => $image)
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card dog-card h-100">
                                @if($image)
                                <img src="{{ $image }}" class="card-img-top dog-image" alt="{{ $breed }}"
                                     onerror="this.src='https://via.placeholder.com/300x200/667eea/ffffff?text=No+Image'">
                                @else
                                <div class="card-img-top dog-image bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-dog fa-3x text-muted"></i>
                                </div>
                                @endif
                                <div class="card-body text-center">
                                    <h5 class="card-title">{{ ucfirst(str_replace('-', ' ', $breed)) }}</h5>
                                    <p class="card-text">
                                        <small class="text-muted">Click like to add to favorites</small>
                                    </p>
                                    
                                    @if(auth()->user()->hasLikedBreed($breed))
                                        <button class="btn btn-success btn-sm" disabled>
                                            <i class="fas fa-heart me-1"></i> Liked
                                        </button>
                                    @elseif(auth()->user()->getLikedBreedsCount() >= 3)
                                        <button class="btn btn-secondary btn-sm" disabled>
                                            <i class="fas fa-heart me-1"></i> Limit Reached
                                        </button>
                                    @else
                                        <button class="btn btn-outline-primary btn-sm like-btn" 
                                                data-breed="{{ $breed }}" 
                                                data-image="{{ $image }}">
                                            <i class="far fa-heart me-1"></i> Like
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-warning text-center">
                        <i class="fas fa-exclamation-triangle me-2"></i> No dog breeds available at the moment. Please try again later.
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-dog fa-2x text-primary mb-2"></i>
                            <h5>{{ count($breedsWithImages) }}</h5>
                            <p class="text-muted">Available Breeds</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-heart fa-2x text-danger mb-2"></i>
                            <h5>{{ $userLikedDogs->count() }}</h5>
                            <p class="text-muted">Your Favorites</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="fas fa-users fa-2x text-success mb-2"></i>
                            <h5>{{ \App\Models\User::count() }}</h5>
                            <p class="text-muted">Total Users</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // Like button handler
        $('.like-btn').click(function() {
            const button = $(this);
            const breed = button.data('breed');
            const image = button.data('image');

            $.ajax({
                url: '{{ route("dogs.like") }}',
                method: 'POST',
                data: {
                    breed_name: breed,
                    image_url: image,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        alert('🐶 Dog breed liked successfully!');
                        location.reload();
                    } else {
                        alert('❌ ' + response.message);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    alert('❌ ' + (response?.message || 'An error occurred'));
                }
            });
        });

        // Unlike button handler
        $('.unlike-btn').click(function() {
            const button = $(this);
            const id = button.data('id');

            if (confirm('Are you sure you want to remove this dog breed from your favorites?')) {
                $.ajax({
                    url: '/dogs/unlike/' + id,
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            alert('🐶 Dog breed removed from favorites!');
                            location.reload();
                        } else {
                            alert('❌ ' + response.message);
                        }
                    },
                    error: function(xhr) {
                        const response = xhr.responseJSON;
                        alert('❌ ' + (response?.message || 'An error occurred'));
                    }
                });
            }
        });
    });
    </script>
</body>
</html>