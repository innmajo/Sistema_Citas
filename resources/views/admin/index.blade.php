<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Panel de Administración - Estadísticas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h3 class="text-lg font-bold mb-6 text-gray-700">Resumen General del Sistema</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                    <!-- Tarjeta Usuarios -->
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded shadow-sm">
                        <p class="text-blue-600 font-semibold uppercase text-xs">Total Usuarios</p>
                        <p class="text-3xl font-bold text-blue-900">{{ $stats['total_users'] }}</p>
                    </div>

                    <!-- Tarjeta Servicios -->
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded shadow-sm">
                        <p class="text-green-600 font-semibold uppercase text-xs">Total Servicios</p>
                        <p class="text-3xl font-bold text-green-900">{{ $stats['total_servicios'] }}</p>
                    </div>

                    <!-- Tarjeta Admins -->
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded shadow-sm">
                        <p class="text-red-600 font-semibold uppercase text-xs">Administradores</p>
                        <p class="text-3xl font-bold text-red-900">{{ $stats['admins'] }}</p>
                    </div>
                </div>

                <h3 class="text-lg font-bold mb-4 text-gray-700">Distribución de Usuarios por Rol</h3>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">Rol</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">Cantidad</th>
                                <th class="px-6 py-3 border-b text-left text-xs font-semibold text-gray-600 uppercase">Porcentaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-6 py-4 border-b text-sm font-medium text-gray-700">Administradores</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-600">{{ $stats['admins'] }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-600">
                                    {{ $stats['total_users'] > 0 ? number_format(($stats['admins'] / $stats['total_users']) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 border-b text-sm font-medium text-gray-700">Editores</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-600">{{ $stats['editors'] }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-600">
                                    {{ $stats['total_users'] > 0 ? number_format(($stats['editors'] / $stats['total_users']) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 border-b text-sm font-medium text-gray-700">Usuarios</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-600">{{ $stats['usuarios'] }}</td>
                                <td class="px-6 py-4 border-b text-sm text-gray-600">
                                    {{ $stats['total_users'] > 0 ? number_format(($stats['usuarios'] / $stats['total_users']) * 100, 1) : 0 }}%
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-8">
                    <a href="{{ route('dashboard') }}" class="bg-gray-600 hover:bg-gray-800 text-white font-bold py-2 px-4 rounded transition">
                        Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
