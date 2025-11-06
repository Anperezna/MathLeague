<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Opciones extends Model
{
    protected $table = 'opciones';
    protected $primaryKey = 'opcion1';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['id_pregunta', 'opcion2', 'opcion3', 'opcion4'];


    public function preguntas(): BelongsTo
    {
        return $this->belongsTo(Preguntas::class, 'id_pregunta', 'id_pregunta');
    }
}
