<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'monto',
        'semana',
    ];

    /**
     * Un presupuesto pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un presupuesto tiene muchos gastos.
     */
    public function gastos()
    {
        return $this->hasMany(Gasto::class);
    }
}
