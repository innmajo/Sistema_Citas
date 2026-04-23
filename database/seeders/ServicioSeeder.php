<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servicio;

class ServicioSeeder extends Seeder
{
    /**
     * Sembrar datos iniciales de servicios (Mínimo 5 requeridos)
     */
    public function run(): void
    {
        $servicios = [
            ['nombre' => 'Corte de Cabello Hombre', 'precio' => 15000],
            ['nombre' => 'Corte de Cabello Mujer', 'precio' => 25000],
            ['nombre' => 'Barba y Bigote', 'precio' => 8000],
            ['nombre' => 'Tinte de Cabello', 'precio' => 45000],
            ['nombre' => 'Peinado Especial', 'precio' => 30000],
            ['nombre' => 'Lavado y Secado', 'precio' => 12000],
        ];

        foreach ($servicios as $servicio) {
            Servicio::create($servicio);
        }
    }
}
