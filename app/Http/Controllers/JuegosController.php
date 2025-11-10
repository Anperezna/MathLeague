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

        // Obtener las opciones de la pregunta
        $opciones = DB::table('opciones')
            ->where('id_pregunta', $pregunta->id_pregunta)
            ->first();

        if (!$opciones) {
            return response()->json([
                'success' => false,
                'message' => 'No hay opciones para esta pregunta',
            ], 404);
        }

        // Determinar cuál opción es la correcta (las opciones son bit: 1=correcta, 0=incorrecta)
        $respuestaCorrecta = null;
        
        // El enunciado debe tener el formato "5 + 3" y las opciones son los números
        // Extraer los números de la operación para generar opciones
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
        $jugador = $request->input('jugador', 'Anónimo');
        $puntos = $request->input('puntos');

        // Por ahora solo retornamos éxito
        // Cuando tengas una tabla de puntuaciones, descomenta esto:
        // DB::table('puntuaciones')->insert([
        //     'jugador' => $jugador,
        //     'puntos' => $puntos,
        //     'created_at' => now(),
        // ]);

        return response()->json([
            'success' => true,
            'message' => 'Puntuación guardada',
            'puntos' => $puntos,
        ]);
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
