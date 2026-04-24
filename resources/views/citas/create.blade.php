<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reservar Nueva Cita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Errores generales -->
                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('citas.store') }}" method="POST">
                        @csrf

                        <!-- Fecha de la Cita -->
                        <div class="mb-4">
                            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha de la Cita</label>
                            <input type="date" name="fecha" id="fecha" value="{{ old('fecha') }}"
                                min="{{ date('Y-m-d') }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('fecha') border-red-500 @enderror">
                            @error('fecha')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Hora de la Cita -->
                        <div class="mb-4">
                            <label for="hora" class="block text-sm font-medium text-gray-700">Hora de la Cita</label>
                            <select name="hora" id="hora"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('hora') border-red-500 @enderror">
                                <option value="">-- Selecciona una hora --</option>
                                @for($h = 8; $h <= 18; $h++)
                                    @foreach(['00', '30'] as $m)
                                        @php $time = sprintf('%02d:%02d', $h, $m); @endphp
                                        <option value="{{ $time }}" {{ old('hora') == $time ? 'selected' : '' }}>
                                            {{ \Carbon\Carbon::parse($time)->format('h:i A') }}
                                        </option>
                                    @endforeach
                                @endfor
                            </select>
                            @error('hora')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Selección Múltiple de Servicios -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Servicios (selecciona uno o más)</label>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach($servicios as $servicio)
                                    <label class="flex items-center p-3 border rounded-lg hover:bg-blue-50 transition cursor-pointer {{ in_array($servicio->id, old('servicios', [])) ? 'bg-blue-50 border-blue-400' : 'border-gray-200' }}">
                                        <input type="checkbox" name="servicios[]" value="{{ $servicio->id }}"
                                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 mr-3"
                                            {{ in_array($servicio->id, old('servicios', [])) ? 'checked' : '' }}>
                                        <div>
                                            <span class="text-sm font-medium text-gray-900">{{ $servicio->nombre }}</span>
                                            <span class="block text-xs text-gray-500">${{ number_format($servicio->precio, 0, ',', '.') }}</span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                            @error('servicios')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('citas.index') }}" class="text-gray-600 hover:text-gray-900 text-sm font-semibold">Cancelar</a>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-800 text-white font-bold py-2 px-6 rounded transition">
                                Reservar Cita
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
