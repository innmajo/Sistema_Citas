<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    /**
     * Campos que se pueden llenar de forma masiva
     */
    protected $fillable = [
        'fecha',
        'hora',
        'usuarioId'
    ];

    /**
     * Relación con el Usuario (Muchos a Uno)
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuarioId');
    }

    /**
     * Relación con Servicios (Muchos a Muchos)
     */
    public function servicios()
    {
        return $this->belongsToMany(Servicio::class, 'citasServicios', 'citaId', 'servicioId');
    }
}
