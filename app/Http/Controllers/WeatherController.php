<?php

namespace App\Http\Controllers;

use App\Models\WeatherSearch;
use App\Services\WeatherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class WeatherController extends Controller
{
    public function __construct(protected WeatherService $weatherService) {}

    public function getWeather(Request $request)
    {
        try {
            $validated = $request->validate([
                'city' => 'required|string'
            ]);

            $data = $this->weatherService->fetchWeather($validated['city']);

            WeatherSearch::create([
                'user_id' => $request->user()->id,
                'city' => $validated['city'],
                'data' => $data
            ]);

            return response()->json($data, 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            Log::error('Error al guardar búsqueda: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error en base de datos',
                'error' => $e->getMessage()
            ], 500);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            Log::error('Error al consultar WeatherAPI: ' . $e->getMessage());
            return response()->json([
                'message' => 'Error al obtener datos del clima',
                'error' => 'Servicio externo no disponible o ciudad inválida.'
            ], 502);
        } catch (\Exception $e) {
            Log::error('Error inesperado en getWeather(): ' . $e->getMessage());
            return response()->json([
                'message' => 'Error inesperado',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function history(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no autenticado.'
                ], 401);
            }

            $history = $user->weatherSearches()->latest()->get();

            return response()->json($history);
        } catch (\Exception $e) {
            Log::error('Error al obtener historial: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al obtener el historial.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
