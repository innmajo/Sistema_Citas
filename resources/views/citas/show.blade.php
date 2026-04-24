<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detalle de la Cita') }} #{{ $cita->id }}
            </h2>
            <a href="{{ route('citas.index') }}" class="text-blue-600 hover:text-blue-900 text-sm font-semibold">
                &larr; Volver al listado
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información General -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-bold border-b pb-2">Información de la Cita</h3>
                            
                            <div>
                                <span class="text-gray-500 text-sm uppercase font-semibold">Fecha:</span>
                                <p class="text-lg">{{ $cita->fecha->format('d/m/Y') }}</p>
                            </div>
                            
                            <div>
                                <span class="text-gray-500 text-sm uppercase font-semibold">Hora:</span>
                                <p class="text-lg">{{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}</p>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm uppercase font-semibold">Estado:</span>
                                <div class="mt-1">
                                    @switch($cita->estado)
                                        @case('pendiente')
                                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">Pendiente</span>
                                            @break
                                        @case('confirmada')
                                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800 border border-green-200">Confirmada</span>
                                            @break
                                        @case('cancelada')
                                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800 border border-red-200">Cancelada</span>
                                            @break
                                        @case('completada')
                                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 border border-blue-200">Completada</span>
                                            @break
                                    @endswitch
                                </div>
                            </div>
                        </div>

                        <!-- Información del Cliente (o detalle extra) -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-bold border-b pb-2">Datos del Cliente</h3>
                            
                            <div>
                                <span class="text-gray-500 text-sm uppercase font-semibold">Nombre Completo:</span>
                                <p class="text-lg">{{ $cita->usuario->nombre }} {{ $cita->usuario->apellido }}</p>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm uppercase font-semibold">Email:</span>
                                <p class="">{{ $cita->usuario->email }}</p>
                            </div>

                            <div>
                                <span class="text-gray-500 text-sm uppercase font-semibold">Teléfono:</span>
                                <p class="">{{ $cita->usuario->telefono ?? 'No registrado' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Servicios Seleccionados -->
                    <div class="mt-8">
                        <h3 class="text-lg font-bold border-b pb-2 mb-4">Servicios Contratados</h3>
                        <div class="bg-gray-50 rounded-lg overflow-hidden border">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Servicio</th>
                                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Precio</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($cita->servicios as $servicio)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $servicio->nombre }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 text-right">${{ number_format($servicio->precio, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Total a Pagar</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900 text-right">${{ number_format($cita->precio_total, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Acciones Disponibles -->
                    <div class="mt-8 pt-6 border-t flex flex-wrap gap-3">
                        @if(!in_array($cita->estado, ['cancelada', 'completada']))
                            <a href="{{ route('citas.edit', $cita) }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded transition">
                                Editar Cita
                            </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                            @if($cita->estado === 'pendiente')
                                <form action="{{ route('citas.cambiarEstado', $cita) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="estado" value="confirmada">
                                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded transition">
                                        Confirmar Cita
                                    </button>
                                </form>
                            @endif

                            @if($cita->estado === 'confirmada')
                                <form action="{{ route('citas.cambiarEstado', $cita) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="estado" value="completada">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded transition">
                                        Marcar como Completada
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
