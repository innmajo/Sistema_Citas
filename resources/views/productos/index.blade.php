<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Consulta de Productos') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Total de registros -->
                    <div class="mb-6">
                        <h5 class="text-lg font-semibold">
                            Total de Registro: <strong class="text-blue-600">{{ $totalptoductos }}</strong>
                        </h5>
                        <hr class="mt-2">
                    </div>
                    <!-- Tabla de productos -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto border-collapse border border-gray-200">
                            <thead class="bg-blue-50">
                                <tr>
                                    <th
                                        class="border border-gray-200 px-4 py-3 text-left text-sm font-medium text-gray-700">
                                        Producto</th>
                                    <th
                                        class="border border-gray-200 px-4 py-3 text-left text-sm font-medium text-gray-700">
                                        Referencia</th>
                                    <th
                                        class="border border-gray-200 px-4 py-3 text-left text-sm font-medium text-gray-700">
                                        Description</th>
                                    <th
                                        class="border border-gray-200 px-4 py-3 text-left text-sm font-medium text-gray-700">
                                        Cantidad</th>
                                    <th
                                        class="border border-gray-200 px-4 py-3 text-left text-sm font-medium text-gray-700">
                                        Precio</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($produc as $value)
                                    <tr class="hover:bg-gray-50">
                                        <td class="border border-gray-200 px-4 py-3 text-sm">{{ $value->producto }}</td>
                                        <td class="border border-gray-200 px-4 py-3 text-sm">{{ $value->referencia }}</td>
                                        <td class="border border-gray-200 px-4 py-3 text-sm">{{ $value->description }}</td>
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-center">
                                            {{ $value->cantidad }}</td>
                                        <td class="border border-gray-200 px-4 py-3 text-sm text-right">
                                            ${{ number_format($value->precio_und) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Botones de acción -->
                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('dashboard') }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Volver al Dashboard
                        </a>
                        <a href="{{ route('usuario.index') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Gestionar Usuarios
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>