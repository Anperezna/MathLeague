<?php

namespace App\Http\Controllers;

use App\Models\Juegos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JuegosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('mathbus');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Juegos $juegos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Juegos $juegos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Juegos $juegos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Juegos $juegos)
    {
        //
    }

    // Obtener una operación aleatoria
    public function getOperation()
    {
        // Buscar el juego MathBus por nombre
        $juego = DB::table('juegos')
            ->where('nombre', 'LIKE', '%MathBus%')
            ->orWhere('nombre', 'LIKE', '%mathbus%')
            ->first();
        
        if (!$juego) {
            return response()->json([
                'success' => false,
                'message' => 'Juego MathBus no encontrado. Verifica que existe en la tabla juegos.',
            ], 404);
        }

        // Obtener una pregunta aleatoria del juego
        $pregunta = DB::table('preguntas')
            ->where('id_juego', $juego->id_juego)
            ->inRandomOrder()
            ->first();

        if (!$pregunta) {
            return response()->json([
                'success' => false,
                'message' => 'No hay preguntas disponibles para este juego',
            ], 404);
        }

        // Calcular la respuesta correcta a partir del enunciado
        $respuestaCorrecta = null;
        
        // El enunciado debe tener el formato "5 + 3"
        // Extraer los números de la operación para calcular la respuesta
        if (preg_match('/(\d+)\s*([+\-*\/])\s*(\d+)/', $pregunta->enunciado, $matches)) {
            $num1 = (int)$matches[1];
            $num2 = (int)$matches[3];
            $operador = $matches[2];
            
            // Calcular la respuesta correcta
            switch ($operador) {
                case '+':
                    $respuestaCorrecta = $num1 + $num2;
                    break;
                case '-':
                    $respuestaCorrecta = $num1 - $num2;
                    break;
                case '*':
                    $respuestaCorrecta = $num1 * $num2;
                    break;
                case '/':
                    $respuestaCorrecta = $num2 != 0 ? (int)($num1 / $num2) : 0;
                    break;
            }
        }

        return response()->json([
            'success' => true,
            'operacion' => [
                'id' => $pregunta->id_pregunta,
                'operacion' => $pregunta->enunciado,
                'respuesta' => $respuestaCorrecta,
            ],
        ]);
    }

    // Verificar si la respuesta es correcta
    public function checkAnswer(Request $request)
    {
        $operacionId = $request->input('operacion_id');
        $respuestaUsuario = $request->input('respuesta');

        $operacion = DB::table('operaciones')
            ->where('id', $operacionId)
            ->first();

        if (! $operacion) {
            return response()->json([
                'success' => false,
                'message' => 'Operación no encontrada',
            ], 404);
        }

        $esCorrecta = ($operacion->respuesta == $respuestaUsuario);

        return response()->json([
            'success' => true,
            'correcta' => $esCorrecta,
            'respuesta_correcta' => $operacion->respuesta,
        ]);
    }

    // Guardar puntuación
    public function saveScore(Request $request)
    {
        $puntos = $request->input('puntos', 0);
        $errores = $request->input('errores', 0);
        $aciertos = (int)($puntos / 10); // Cada acierto vale 10 puntos
        $intentos = $aciertos + $errores;
        
        // Por ahora usar un usuario por defecto (ID 1)
        // En producción, esto debería ser el usuario autenticado
        $id_usuario = 1;
        
        // Buscar el juego MathBus
        $juego = DB::table('juegos')
            ->where('nombre', 'LIKE', '%MathBus%')
            ->first();
            
        if (!$juego) {
            return response()->json([
                'success' => false,
                'message' => 'Juego no encontrado',
            ], 404);
        }
        
        try {
            // Obtener el siguiente ID para sesion
            $next_sesion_id = DB::table('sesiones')->max('id_sesion');
            $next_sesion_id = $next_sesion_id ? $next_sesion_id + 1 : 1;
            
            // Insertar en tabla sesiones
            DB::table('sesiones')->insert([
                'id_sesion' => $next_sesion_id,
                'date_time' => now(),
                'sesion_lenght' => 0, // Duración en segundos (puedes calcularlo desde el cliente)
                'n_attemps' => $intentos,
                'errores' => $errores,
                'points_scored' => $puntos,
                'help_clicks' => 0,
                'completado' => $errores >= 3 ? 0 : 1, // Completado si terminó antes de 3 errores
                'id_usuario' => $id_usuario,
            ]);
            
            // Obtener el siguiente ID para juegos_sesion
            $next_juego_sesion_id = DB::table('juegos_sesion')->max('id_juegos_sesion');
            $next_juego_sesion_id = $next_juego_sesion_id ? $next_juego_sesion_id + 1 : 1;
            
            // Insertar en tabla juegos_sesion
            DB::table('juegos_sesion')->insert([
                'id_juegos_sesion' => $next_juego_sesion_id,
                'numero_nivel' => 1,
                'level_length' => 0,
                'completado' => $errores >= 3 ? 0 : 1,
                'errores_nivel' => $errores,
                'intentos_nivel' => $intentos,
                'id_sesion' => $next_sesion_id,
                'id_juego' => $juego->id_juego,
                'puntuacion' => $puntos,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Puntuación y sesión guardadas correctamente',
                'puntos' => $puntos,
                'id_sesion' => $next_sesion_id,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la sesión: ' . $e->getMessage(),
            ], 500);
        }
    }

    // Obtener mejores puntuaciones
    public function getHighScores()
    {
        // Por ahora retornamos un array vacío
        // Cuando tengas una tabla de puntuaciones, descomenta esto:
        // $scores = DB::table('puntuaciones')
        //     ->orderBy('puntos', 'desc')
        //     ->limit(10)
        //     ->get();

        $scores = [];

        return response()->json([
            'success' => true,
            'scores' => $scores,
        ]);
    }
}
