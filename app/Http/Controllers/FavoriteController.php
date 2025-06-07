<?php

namespace App\Http\Controllers;

use App\Models\FavoriteCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    public function add(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required|string'
            ]);

            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no autenticado.'
                ], 401);
            }

            $favorite = FavoriteCity::firstOrCreate([
                'user_id' => $user->id,
                'city'    => $request->city
            ]);

            return response()->json([
                'message' => 'Ciudad marcada como favorita',
                'data'    => $favorite
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Error de validación',
                'errors'  => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error al agregar ciudad favorita: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al agregar ciudad favorita',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function list(Request $request)
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no autenticado.'
                ], 401);
            }

            $favorites = FavoriteCity::where('user_id', $user->id)->get();

            return response()->json([
                'favorites' => $favorites
            ]);
        } catch (\Exception $e) {
            Log::error('Error al obtener ciudades favoritas: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al obtener ciudades favoritas',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function remove(Request $request)
    {
        try {
            $request->validate([
                'city' => 'required|string'
            ]);

            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'message' => 'Usuario no autenticado.'
                ], 401);
            }

            $deleted = FavoriteCity::where('user_id', $user->id)
                ->where('city', $request->city)
                ->delete();

            if ($deleted) {
                return response()->json(['message' => 'Ciudad favorita eliminada']);
            } else {
                return response()->json(['message' => 'Ciudad favorita no encontrada'], 404);
            }
        } catch (\Exception $e) {
            Log::error('Error al eliminar ciudad favorita: ' . $e->getMessage());

            return response()->json([
                'message' => 'Error al eliminar ciudad favorita',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
