<?php

namespace App\Http\Controllers;
use App\Models\UserLikeDog;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('likedDogs')
            ->where('id', '!=', auth()->id())
            ->get()
            ->map(function ($user) {
                $user->liked_dogs_count = $user->likedDogs->count();
                return $user;
            });

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('likedDogs');
        return view('users.show', compact('user'));
    }
}