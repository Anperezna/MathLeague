<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Usuarios extends Model
{
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['id_usuario', 'username', 'email', 'contraseña', 'fecha_registro'];

    public function sesiones(): HasMany
    {
        return $this->hasMany(Sesiones::class, 'id_usuario', 'id_usuario');
    }
}
