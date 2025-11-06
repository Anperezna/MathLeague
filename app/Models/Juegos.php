<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Juegos extends Model
{
    protected $table = 'juegos';
    protected $primaryKey = 'id_juego';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['nombre', 'tipo_operacion', 'orden'];


    public function sesiones(): HasMany
    {
        return $this->hasMany(Sesiones::class, 'id_juego', 'id_juego');
    }

    /**
     * Relación hacia la tabla intermedia `juegos_sesion` (muchos registros por juego)
     */
    public function juegosSesion(): HasMany
    {
        return $this->hasMany(Juegos_Sesion::class, 'id_juego', 'id_juego');
    }
}
