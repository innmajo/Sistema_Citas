<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mis Citas') }}
                @if(auth()->user()->isAdmin())
                    <span class="text-sm font-normal text-gray-500">(Vista Administrativa)</span>
                @endif
            </h2>
            <a href="{{ route('citas.create') }}" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-4 rounded text-sm transition">
                + Nueva Cita
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes de estado -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-6 text-gray-600">Gestiona tus citas y servicios agendados.</p>

                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b">
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Hora</th>
                                    @if(auth()->user()->isAdmin())
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Cliente</th>
                                    @endif
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Servicios</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Total</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Estado</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($citas as $cita)
                                    <tr class="hover:bg-gray-50 transition">
                                        <!-- Fecha formateada -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $cita->fecha->format('d/m/Y') }}
                                        </td>
                                        <!-- Hora formateada -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($cita->hora)->format('h:i A') }}
                                        </td>
                                        <!-- Nombre del cliente (Solo Admin) -->
                                        @if(auth()->user()->isAdmin())
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                                {{ $cita->usuario->nombre ?? 'N/A' }} {{ $cita->usuario->apellido ?? '' }}
                                            </td>
                                        @endif
                                        <!-- Lista de servicios asociados -->
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            @foreach($cita->servicios as $servicio)
                                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-1 mb-1">
                                                    {{ $servicio->nombre }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <!-- Precio total calculado -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">
                                            ${{ number_format($cita->precio_total, 0, ',', '.') }}
                                        </td>
                                        <!-- Badge de estado con colores -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @switch($cita->estado)
                                                @case('pendiente')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pendiente</span>
                                                    @break
                                                @case('confirmada')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Confirmada</span>
                                                    @break
                                                @case('cancelada')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Cancelada</span>
                                                    @break
                                                @case('completada')
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Completada</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <!-- Acciones -->
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center space-x-1">
                                            <!-- Ver detalle -->
                                            <a href="{{ route('citas.show', $cita) }}" class="text-blue-600 hover:text-blue-900" title="Ver detalle">
                                                Ver
                                            </a>

                                            @if(!in_array($cita->estado, ['cancelada', 'completada']))
                                                <!-- Editar -->
                                                <a href="{{ route('citas.edit', $cita) }}" class="text-indigo-600 hover:text-indigo-900" title="Editar cita">
                                                    | Editar
                                                </a>

                                                <!-- Cambiar estado (Solo Admin) -->
                                                @if(auth()->user()->isAdmin())
                                                    @if($cita->estado === 'pendiente')
                                                        <form action="{{ route('citas.cambiarEstado', $cita) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="estado" value="confirmada">
                                                            <button type="submit" class="text-green-600 hover:text-green-900" title="Confirmar cita">
                                                                | Confirmar
                                                            </button>
                                                        </form>
                                                    @endif
                                                    @if($cita->estado === 'confirmada')
                                                        <form action="{{ route('citas.cambiarEstado', $cita) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="estado" value="completada">
                                                            <button type="submit" class="text-blue-600 hover:text-blue-900" title="Marcar completada">
                                                                | Completar
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <!-- Cancelar -->
                                                    <form action="{{ route('citas.cambiarEstado', $cita) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="estado" value="cancelada">
                                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Estás seguro de cancelar esta cita?')" title="Cancelar cita">
                                                            | Cancelar
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif

                                            <!-- Eliminar (Solo Admin) -->
                                            @if(auth()->user()->isAdmin())
                                                <form action="{{ route('citas.destroy', $cita) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Eliminar esta cita permanentemente?')" title="Eliminar cita">
                                                        | Eliminar
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No hay citas registradas.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
