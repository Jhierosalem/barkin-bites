<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class DogApiService
{
    protected $baseUrl = 'https://dog.ceo/api';

    public function getAllBreeds()
    {
        return Cache::remember('all_dog_breeds', 3600, function () {
            $response = Http::get("{$this->baseUrl}/breeds/list/all");
            
            if ($response->successful()) {
                $data = $response->json();
                $breeds = [];
                
                foreach ($data['message'] as $breed => $subBreeds) {
                    if (empty($subBreeds)) {
                        $breeds[] = $breed;
                    } else {
                        foreach ($subBreeds as $subBreed) {
                            $breeds[] = "{$subBreed} {$breed}";
                        }
                    }
                }
                
                return $breeds;
            }
            
            return [];
        });
    }

    public function getRandomImage($breed)
    {
        if (str_contains($breed, ' ')) {
            $parts = explode(' ', $breed);
            $breed = "{$parts[1]}/{$parts[0]}";
        }

        return Cache::remember("dog_image_{$breed}", 3600, function () use ($breed) {
            $response = Http::get("{$this->baseUrl}/breed/{$breed}/images/random");
            
            if ($response->successful()) {
                $data = $response->json();
                return $data['message'];
            }
            
            return null;
        });
    }
}