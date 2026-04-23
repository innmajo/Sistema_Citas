<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Producto;
class ProductoTableSeeder extends Seeder
{
    public function run()
    {
        // Limpiar tabla antes de insertar
        Producto::truncate();
        // Crear productos de ejemplo
        Producto::create([
            'producto' => 'Caja Pizza 30x30',
            'referencia' => 'F5464',
            'description' => 'Caja para pizzería',
            'cantidad' => 100,
            'precio_und' => 300,
        ]);
        Producto::create([
            'producto' => 'Salero',
            'referencia' => 'FGL464',
            'description' => 'Salero blanco para restaurante',
            'cantidad' => 100,
            'precio_und' => 20000,
        ]);
        Producto::create([
            'producto' => 'Plato Hondo',
            'referencia' => 'PH001',
            'description' => 'Plato hondo para sopa',
            'cantidad' => 50,
            'precio_und' => 15000,
        ]);
        Producto::create([
            'producto' => 'Vaso Cristal',
            'referencia' => 'VC200',
            'description' => 'Vaso de cristal transparente',
            'cantidad' => 200,
            'precio_und' => 8000,
        ]);
    }
}