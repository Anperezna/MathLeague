<?php

namespace App\Http\Controllers;

use App\Models\Juegos;
use App\Models\Preguntas;
use App\Models\Sesiones;
use App\Models\Juegos_Sesion;
use App\Models\Usuarios;
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
        // Buscar el juego MathBus por nombre usando Eloquent
        $juego = Juegos::where('nombre', 'LIKE', '%MathBus%')
            ->orWhere('nombre', 'LIKE', '%mathbus%')
            ->first();
        
        if (!$juego) {
            return response()->json([
                'success' => false,
                'message' => 'Juego MathBus no encontrado. Verifica que existe en la tabla juegos.',
            ], 404);
        }

        // Obtener una pregunta aleatoria del juego usando Eloquent
        $pregunta = Preguntas::where('id_juego', $juego->id_juego)
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
        
        // Buscar el juego MathBus usando Eloquent
        $juego = Juegos::where('nombre', 'LIKE', '%MathBus%')->first();
            
        if (!$juego) {
            return response()->json([
                'success' => false,
                'message' => 'Juego no encontrado',
            ], 404);
        }
        
        try {
            // Crear sesión usando Eloquent
            $sesion = new Sesiones();
            $sesion->date_time = now();
            $sesion->sesion_lenght = 0; // Duración en segundos (puedes calcularlo desde el cliente)
            $sesion->n_attemps = $intentos;
            $sesion->errores = $errores;
            $sesion->points_scored = $puntos;
            $sesion->help_clicks = 0;
            $sesion->completado = $errores >= 3 ? 0 : 1; // Completado si terminó antes de 3 errores
            $sesion->id_usuario = $id_usuario;
            $sesion->save();
            
            // Crear juegos_sesion usando Eloquent
            $juegoSesion = new Juegos_Sesion();
            $juegoSesion->numero_nivel = 1;
            $juegoSesion->level_length = 0;
            $juegoSesion->completado = $errores >= 3 ? 0 : 1;
            $juegoSesion->errores_nivel = $errores;
            $juegoSesion->intentos_nivel = $intentos;
            $juegoSesion->id_sesion = $sesion->id_sesion;
            $juegoSesion->id_juego = $juego->id_juego;
            $juegoSesion->puntuacion = $puntos;
            $juegoSesion->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Puntuación y sesión guardadas correctamente',
                'puntos' => $puntos,
                'id_sesion' => $sesion->id_sesion,
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al guardar la sesión: ' . $e->getMessage(),
            ], 500);
        }
    }    // Obtener mejores puntuaciones
    public function getHighScores()
    {
        // Obtener las mejores puntuaciones usando Eloquent con relaciones
        $juego = Juegos::where('nombre', 'LIKE', '%MathBus%')->first();
        
        if (!$juego) {
            return response()->json([
                'success' => false,
                'message' => 'Juego no encontrado',
            ], 404);
        }
        
        // Obtener top 10 sesiones con mayor puntuación
        $scores = Sesiones::with('usuarios')
            ->whereHas('juegosSesion', function($query) use ($juego) {
                $query->where('id_juego', $juego->id_juego);
            })
            ->orderBy('points_scored', 'desc')
            ->limit(10)
            ->get()
            ->map(function($sesion) {
                return [
                    'id_sesion' => $sesion->id_sesion,
                    'puntos' => $sesion->points_scored,
                    'errores' => $sesion->errores,
                    'usuario' => $sesion->usuarios->username ?? 'Usuario',
                    'fecha' => $sesion->date_time,
                ];
            });

        return response()->json([
            'success' => true,
            'scores' => $scores,
        ]);
    }
}
