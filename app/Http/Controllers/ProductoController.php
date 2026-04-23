<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Producto;
use Illuminate\Routing\Controller;
class ProductoController extends Controller
{
    public function index(Request $request)
    {
        // OBTENER DATOS DESDE LA BASE DE DATOS
        $productos = Producto::all();
        $totalProductos = Producto::count();

        // Preparar datos para la vista (mismos nombres que en la presentación)
        $data = [
            'produc' => $productos,
            'totalptoductos' => $totalProductos
        ];

        return view('productos.index')->with($data);
    }
}

