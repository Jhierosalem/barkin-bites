<?php

namespace App\Http\Controllers;

use App\Models\UserDogLike;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DogController extends Controller
{
    public function dashboard()
    {
        try {
            // Fetch all dog breeds
            $response = Http::get('https://dog.ceo/api/breeds/list/all');
            
            if (!$response->successful()) {
                throw new \Exception('Failed to fetch dog breeds from API');
            }

            $breedsData = $response->json();
            $breeds = [];
            
            if ($breedsData['status'] === 'success') {
                $breeds = array_keys($breedsData['message']);
            }

            // Get random images for breeds (limit to 12 for better performance)
            $breedsWithImages = [];
            $selectedBreeds = array_slice($breeds, 0, 12);
            
            foreach ($selectedBreeds as $breed) {
                try {
                    $imageResponse = Http::get("https://dog.ceo/api/breed/{$breed}/images/random");
                    if ($imageResponse->successful()) {
                        $imageData = $imageResponse->json();
                        $breedsWithImages[$breed] = $imageData['message'] ?? null;
                    } else {
                        $breedsWithImages[$breed] = null;
                    }
                } catch (\Exception $e) {
                    Log::error("Failed to fetch image for breed: {$breed}", ['error' => $e->getMessage()]);
                    $breedsWithImages[$breed] = null;
                }
            }

            // Get user's liked dogs
            $userLikedDogs = auth()->user()->likedDogs;

            return view('dashboard', compact('breedsWithImages', 'userLikedDogs'));

        } catch (\Exception $e) {
            Log::error('Dashboard error: ' . $e->getMessage());
            
            // Return empty data but still show the page
            $breedsWithImages = [];
            $userLikedDogs = auth()->user()->likedDogs;
            
            return view('dashboard', compact('breedsWithImages', 'userLikedDogs'))
                ->withErrors(['error' => 'Failed to load dog breeds. Please try again later.']);
        }
    }

    public function likeDog(Request $request)
    {
        $request->validate([
            'breed_name' => 'required|string',
            'image_url' => 'required|url',
        ]);

        $user = auth()->user();

        // Check if user already liked 3 dogs
        if ($user->getLikedBreedsCount() >= 3) {
            return response()->json([
                'success' => false,
                'message' => 'You can only like up to 3 dog breeds.'
            ], 422);
        }

        // Check if already liked this breed
        if ($user->hasLikedBreed($request->breed_name)) {
            return response()->json([
                'success' => false,
                'message' => 'You have already liked this breed.'
            ], 422);
        }

        try {
            $likedDog = UserDoglike::create([
                'user_id' => $user->id,
                'breed_name' => $request->breed_name,
                'image_url' => $request->image_url,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Dog breed liked successfully!',
                'likedDog' => $likedDog
            ]);

        } catch (\Exception $e) {
            Log::error('Like dog error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to like dog breed. Please try again.'
            ], 500);
        }
    }

    public function unlikeDog($id)
    {
        try {
            $likedDog = UserDogLike::where('user_id', auth()->id())->findOrFail($id);
            $likedDog->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dog breed unliked successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Unlike dog error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to unlike dog breed. Please try again.'
            ], 500);
        }
    }
}