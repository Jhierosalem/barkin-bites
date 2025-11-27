<?php

namespace App\Http\Controllers;
use App\Models\UserDogLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Simple test version - we'll add dog breeds later
        return view('dashboard', [
            'user' => Auth::user(),
            'message' => 'Dashboard is working! 🎉',
            'breedsWithImages' => [],
            'userLikes' => []
        ]);
    }
}