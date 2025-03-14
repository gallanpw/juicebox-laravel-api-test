<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $apiKey = env('OPENWEATHER_API_KEY'); // Ambil API key dari .env
        // $city = $request->query('city', 'Perth'); // Default ke Perth jika tidak ada input
        $city = strtolower($request->query('city', 'Perth')); // Default ke Perth (case insensitive)
        // $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";

        // $response = Http::get($url);

        // if ($response->failed()) {
        //     return response()->json(['message' => 'Failed to retrieve weather data'], 500);
        // }

        // return response()->json($response->json());

        // Gunakan Cache agar API hanya dipanggil setiap 15 menit
        return Cache::remember("weather_{$city}", 900, function () use ($apiKey, $city) {
            try {
                // $apiKey = env('OPENWEATHER_API_KEY'); // Ambil API key dari .env
                // $city = $request->query('city', 'Perth'); // Default ke Perth jika tidak ada input
                $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                    'q' => $city,
                    'appid' => $apiKey,
                    'units' => 'metric'
                ]);

                // Jika API gagal, log error dan kembalikan respons 500
                if ($response->failed()) {
                    Log::error('Weather API request failed', ['response' => $response->body()]);
                    return response()->json(['message' => 'Failed to fetch weather data'], 500);
                }

                return response()->json($response->json());
                // $data = $response->json();
                // return response()->json([
                //     'city' => $data['name'],
                //     'temperature' => $data['main']['temp'],
                //     'humidity' => $data['main']['humidity'],
                //     'description' => $data['weather'][0]['description'],
                // ]);
        
            } catch (\Exception $e) {
                Log::error('Weather API Exception', ['error' => $e->getMessage()]);
                return response()->json(['message' => 'An error occurred while fetching weather data'], 500);
            }
        });
    }
}
