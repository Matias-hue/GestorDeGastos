<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'presupuesto_id',
        'descripcion',
        'monto',
        'fecha',
    ];

    protected $casts = [
        'fecha' => 'datetime',
    ];

    /**
     * Un gasto pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Un gasto pertenece a un presupuesto.
     */
    public function presupuesto()
    {
        return $this->belongsTo(Presupuesto::class);
    }
}
