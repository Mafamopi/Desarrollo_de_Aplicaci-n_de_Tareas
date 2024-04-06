<div x-data="{ open: false, tareaId: null, tareaNombre: '', tareaEstado: '' }" class="container mx-auto mt-5 p-5 bg-gray-100 rounded shadow">
    <button @click="open = true" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar tarea</button>

    <div x-show="open" @click.away="open = false" class="mt-3 p-3 bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
            <input x-model="tareaNombre" type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Estado:</label>
            <select x-model="tareaEstado" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                <option value="">...Seleccione...</option>
                <option value="pendiente">Pendiente</option>
                <option value="completada">Completada</option>
            </select>
        </div>
        <button @click="open = false; $wire.saveTarea(tareaId, tareaNombre, tareaEstado)" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
    </div>

    <div class="w-full flex justify-end my-4">
        <div class="flex items-center">
            <input type="text" wire:model="busqueda" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <button wire:click="buscar" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
        </div>
    </div>
    {{ $busqueda }}
    <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($tareas as $tarea)                            
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <button @click="open = true; tareaId = {{ $tarea->id }}; tareaNombre = '{{ $tarea->nombre }}'; tareaEstado = '{{ $tarea->estado }}'" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                                        <button @click="$wire.deleteTarea({{ $tarea->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tarea->nombre }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $tarea->estado }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>