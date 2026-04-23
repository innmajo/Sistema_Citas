<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    /**
     * Muestra la lista de servicios (Vista pública y administrativa)
     */
    public function index()
    {
        // Obtenemos todos los servicios de la base de datos (Capa de Datos)
        $servicios = Servicio::all();
        
        // Retornamos la vista pasando los datos (Arquitectura MVC)
        return view('servicios.index', compact('servicios'));
    }

    /**
     * Muestra el formulario para crear un nuevo servicio (Solo Admin)
     */
    public function create()
    {
        return view('servicios.create');
    }

    /**
     * Almacena un nuevo servicio en la base de datos
     */
    public function store(Request $request)
    {
        // Validación del lado del servidor (Seguridad y Requerimientos)
        $request->validate([
            'nombre' => 'required|string|max:60|unique:servicios',
            'precio' => 'required|numeric|min:0'
        ], [
            'nombre.required' => 'El nombre del servicio es obligatorio.',
            'nombre.unique' => 'Ya existe un servicio con ese nombre.',
            'precio.required' => 'El precio es obligatorio.',
            'precio.numeric' => 'El precio debe ser un número válido.'
        ]);

        // Creación del registro (Asignación masiva protegida por el Modelo)
        Servicio::create($request->all());

        // Redirección con mensaje de éxito (UI de estado)
        return redirect()->route('servicios.index')->with('success', 'Servicio creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un servicio
     */
    public function edit(Servicio $servicio)
    {
        return view('servicios.edit', compact('servicio'));
    }

    /**
     * Actualiza un servicio en la base de datos
     */
    public function update(Request $request, Servicio $servicio)
    {
        // Validación similar al store pero exceptuando el ID actual para el unique
        $request->validate([
            'nombre' => 'required|string|max:60|unique:servicios,nombre,' . $servicio->id,
            'precio' => 'required|numeric|min:0'
        ]);

        $servicio->update($request->all());

        return redirect()->route('servicios.index')->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Elimina un servicio de la base de datos
     */
    public function destroy(Servicio $servicio)
    {
        $servicio->delete();

        return redirect()->route('servicios.index')->with('success', 'Servicio eliminado correctamente.');
    }
}
