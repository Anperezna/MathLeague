<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sesiones extends Model
{
    protected $table = 'sesiones';
    protected $primaryKey = 'id_sesion';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['id_usuario', 'id_juego', 'date_time', 'sesion_length', 'n_attempts', 
    'errors', 'points_scored', 'help_clicks', 'completedo'];

  
  
    public function usuarios(): BelongsTo
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario', 'id_usuario');
    }

    
    public function juego(): BelongsTo
    {
        return $this->belongsTo(Juegos::class, 'id_juego', 'id_juego');
    }

   
    public function juegosSesion(): HasMany
    {
        return $this->hasMany(Juegos_Sesion::class, 'id_sesion', 'id_sesion');
    }
}
