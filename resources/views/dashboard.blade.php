<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="{{ route('usuario.index') }}"
                            class="block p-6 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100">
                            <h5 class="font-bold text-blue-900">Gestión de Usuarios</h5>
                            <p class="text-blue-700">Crear, editar y eliminar usuarios del sistema</p>
                        </a>

                        <a href="{{ route('servicios.index') }}"
                            class="block p-6 bg-green-50 border border-green-200 rounded-lg hover:bg-green-100 transition">
                            <h5 class="font-bold text-green-900">Catálogo de Servicios</h5>
                            <p class="text-green-700">Ver la lista pública de servicios y precios disponibles</p>
                        </a>

                        <a href="{{ route('citas.index') }}"
                            class="block p-6 bg-purple-50 border border-purple-200 rounded-lg hover:bg-purple-100 transition">
                            <h5 class="font-bold text-purple-900">Agendamiento de Citas</h5>
                            <p class="text-purple-700">Reserva tu cita, selecciona servicios y gestiona tus horarios</p>
                        </a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.index') }}"
                                class="block p-6 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100">
                                <h5 class="font-bold text-red-900">Estadísticas del Sistema</h5>
                                <p class="text-red-700">Ver reportes y métricas detalladas (Solo Admin)</p>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>