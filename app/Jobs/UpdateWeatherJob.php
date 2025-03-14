<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue; // auto generate
// use Illuminate\Foundation\Queue\Queueable; // auto generate
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Weather;

class UpdateWeatherJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $apiKey = env('OPENWEATHER_API_KEY');
            $city = 'Perth';
            $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric";
    
            $response = file_get_contents($url);
            $data = json_decode($response, true);
    
            Log::info("Weather API Response:", $data);
    
            \App\Models\Weather::updateOrCreate(
                ['city' => $city],
                [
                    'temperature' => $data['main']['temp'],
                    'humidity' => $data['main']['humidity'],
                    'description' => $data['weather'][0]['description'],
                    'updated_at' => now(),
                ]
            );
    
            Log::info("Weather data for {$city} updated.");
        } catch (\Exception $e) {
            Log::error("Weather Job Error: " . $e->getMessage());
        }
    }
}
