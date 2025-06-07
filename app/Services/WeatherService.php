<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{

    public function fetchWeather(string $city)
    {
        $cacheKey = 'weather_' . strtolower($city);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        try {
            $response = Http::timeout(5)->get("http://api.weatherapi.com/v1/current.json", [
                'key' => config('services.weatherapi.key'),
                'q'   => $city,
            ]);

            if ($response->failed()) {
                Log::error('WeatherAPI error: ' . $response->body());
                throw new \Exception('No se pudo obtener la información del clima.');
            }

            $json = $response->json();

            $data = [
                'city'        => $json['location']['name'] ?? null,
                'country'     => $json['location']['country'] ?? null,
                'local_time'  => $json['location']['localtime'] ?? null,
                'temperature' => $json['current']['temp_c'] ?? null,
                'condition'   => $json['current']['condition']['text'] ?? null,
                'wind_kph'    => $json['current']['wind_kph'] ?? null,
                'humidity'    => $json['current']['humidity'] ?? null,
            ];

            Cache::put($cacheKey, $data, now()->addMinutes(10));

            return $data;
        } catch (\Exception $e) {
            Log::error('Error al consultar clima: ' . $e->getMessage());

            throw new \Exception('Error inesperado al consultar el clima. Intenta más tarde.');
        }
    }
}
