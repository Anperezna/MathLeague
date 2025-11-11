<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Juegos_Sesion extends Model
{
    protected $table = 'juegos_sesion';
    protected $primaryKey = 'id_juegos_sesion';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['id_juegos_sesion', 'numero_nivel', 'level_length', 'completado', 'errores_nivel', 'intentos_nivel', 'id_sesion', 'id_juego', 'puntuacion'];
    

    public function juego(): BelongsTo
    {
        return $this->belongsTo(Juegos::class, 'id_juego', 'id_juego');
    }
    
  
    public function sesion(): BelongsTo
    {
        return $this->belongsTo(Sesiones::class, 'id_sesion', 'id_sesion');
    }

}
