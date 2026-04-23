<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    /**
     * Campos que se pueden llenar de forma masiva
     */
    protected $fillable = [
        'nombre',
        'precio'
    ];

    /**
     * Relación con Citas (Muchos a Muchos)
     */
    public function citas()
    {
        return $this->belongsToMany(Cita::class, 'citasServicios', 'servicioId', 'citaId');
    }
}
