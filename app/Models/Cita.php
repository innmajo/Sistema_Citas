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
        'usuarioId',
        'estado'
    ];

    /**
     * Casting de atributos para manejo correcto de tipos
     */
    protected function casts(): array
    {
        return [
            'fecha' => 'date',
        ];
    }

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

    /**
     * Calcula el precio total sumando los servicios asociados
     */
    public function getPrecioTotalAttribute()
    {
        return $this->servicios->sum('precio');
    }

    /**
     * Verifica disponibilidad: no se permiten dos citas en la misma fecha y hora
     */
    public static function estaDisponible($fecha, $hora, $excluirId = null)
    {
        $query = self::where('fecha', $fecha)
                     ->where('hora', $hora)
                     ->where('estado', '!=', 'cancelada');

        if ($excluirId) {
            $query->where('id', '!=', $excluirId);
        }

        return $query->count() === 0;
    }
}
