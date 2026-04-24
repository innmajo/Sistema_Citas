<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitaController extends Controller
{
    /**
     * Muestra la lista de citas.
     * - Admin: ve todas las citas del sistema
     * - Usuario normal: ve solo sus propias citas
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            // El administrador ve todas las citas con datos del usuario
            $citas = Cita::with(['usuario', 'servicios'])
                         ->orderBy('fecha', 'desc')
                         ->orderBy('hora', 'desc')
                         ->get();
        } else {
            // El usuario solo ve sus propias citas
            $citas = Cita::with('servicios')
                         ->where('usuarioId', $user->id)
                         ->orderBy('fecha', 'desc')
                         ->orderBy('hora', 'desc')
                         ->get();
        }

        return view('citas.index', compact('citas'));
    }

    /**
     * Muestra el formulario para crear una nueva cita
     */
    public function create()
    {
        // Cargamos todos los servicios activos para la selección múltiple
        $servicios = Servicio::all();

        return view('citas.create', compact('servicios'));
    }

    /**
     * Almacena una nueva cita en la base de datos
     */
    public function store(Request $request)
    {
        // Validación del lado del servidor
        $request->validate([
            'fecha'      => 'required|date|after_or_equal:today',
            'hora'       => 'required|date_format:H:i',
            'servicios'  => 'required|array|min:1',
            'servicios.*'=> 'exists:servicios,id',
        ], [
            'fecha.required'         => 'La fecha de la cita es obligatoria.',
            'fecha.after_or_equal'   => 'La fecha no puede ser anterior a hoy.',
            'hora.required'          => 'La hora de la cita es obligatoria.',
            'servicios.required'     => 'Debes seleccionar al menos un servicio.',
            'servicios.min'          => 'Debes seleccionar al menos un servicio.',
        ]);

        // Verificar disponibilidad (Gestión de disponibilidad)
        if (!Cita::estaDisponible($request->fecha, $request->hora)) {
            return back()->withInput()->withErrors([
                'hora' => 'Ya existe una cita reservada para esa fecha y hora. Por favor elige otro horario.'
            ]);
        }

        // Crear la cita (Capa de Datos - Modelo)
        $cita = Cita::create([
            'fecha'     => $request->fecha,
            'hora'      => $request->hora,
            'usuarioId' => Auth::id(),
            'estado'    => 'pendiente',
        ]);

        // Asociar los servicios seleccionados (Relación Muchos a Muchos)
        $cita->servicios()->attach($request->servicios);

        return redirect()->route('citas.index')->with('success', 'Cita reservada exitosamente.');
    }

    /**
     * Muestra el detalle de una cita específica
     */
    public function show(Cita $cita)
    {
        $user = Auth::user();

        // Solo el dueño de la cita o un admin puede verla
        if (!$user->isAdmin() && $cita->usuarioId !== $user->id) {
            abort(403, 'No tienes permiso para ver esta cita.');
        }

        $cita->load(['usuario', 'servicios']);

        return view('citas.show', compact('cita'));
    }

    /**
     * Muestra el formulario para editar una cita
     */
    public function edit(Cita $cita)
    {
        $user = Auth::user();

        // Solo el dueño o un admin puede editar
        if (!$user->isAdmin() && $cita->usuarioId !== $user->id) {
            abort(403, 'No tienes permiso para editar esta cita.');
        }

        // No se pueden editar citas canceladas o completadas
        if (in_array($cita->estado, ['cancelada', 'completada'])) {
            return redirect()->route('citas.index')->with('error', 'No se puede editar una cita ' . $cita->estado . '.');
        }

        $servicios = Servicio::all();
        $serviciosSeleccionados = $cita->servicios->pluck('id')->toArray();

        return view('citas.edit', compact('cita', 'servicios', 'serviciosSeleccionados'));
    }

    /**
     * Actualiza una cita en la base de datos
     */
    public function update(Request $request, Cita $cita)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && $cita->usuarioId !== $user->id) {
            abort(403, 'No tienes permiso para actualizar esta cita.');
        }

        $request->validate([
            'fecha'      => 'required|date|after_or_equal:today',
            'hora'       => 'required|date_format:H:i',
            'servicios'  => 'required|array|min:1',
            'servicios.*'=> 'exists:servicios,id',
        ], [
            'fecha.required'         => 'La fecha de la cita es obligatoria.',
            'fecha.after_or_equal'   => 'La fecha no puede ser anterior a hoy.',
            'hora.required'          => 'La hora de la cita es obligatoria.',
            'servicios.required'     => 'Debes seleccionar al menos un servicio.',
        ]);

        // Verificar disponibilidad excluyendo la cita actual
        if (!Cita::estaDisponible($request->fecha, $request->hora, $cita->id)) {
            return back()->withInput()->withErrors([
                'hora' => 'Ya existe una cita reservada para esa fecha y hora. Por favor elige otro horario.'
            ]);
        }

        // Actualizar la cita
        $cita->update([
            'fecha' => $request->fecha,
            'hora'  => $request->hora,
        ]);

        // Sincronizar servicios (reemplaza los anteriores por los nuevos)
        $cita->servicios()->sync($request->servicios);

        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente.');
    }

    /**
     * Elimina una cita de la base de datos (Solo Admin)
     */
    public function destroy(Cita $cita)
    {
        $user = Auth::user();

        if (!$user->isAdmin() && $cita->usuarioId !== $user->id) {
            abort(403, 'No tienes permiso para eliminar esta cita.');
        }

        // Desasociar servicios y eliminar la cita
        $cita->servicios()->detach();
        $cita->delete();

        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente.');
    }

    /**
     * Cambia el estado de una cita (Solo Admin)
     * Estados: pendiente -> confirmada -> completada | cancelada
     */
    public function cambiarEstado(Request $request, Cita $cita)
    {
        $request->validate([
            'estado' => 'required|in:pendiente,confirmada,cancelada,completada',
        ]);

        $cita->update(['estado' => $request->estado]);

        return redirect()->route('citas.index')->with('success', 'Estado de la cita actualizado a: ' . ucfirst($request->estado));
    }
}
