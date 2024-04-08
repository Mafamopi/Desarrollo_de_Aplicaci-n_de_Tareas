<div x-data="{ open: false, tareaId: null, tareaNombre: '', tareaEstado: '', showConfirmation: false, actionType: '', tareaToDelete: null }" class="container mx-auto mt-5 p-5 bg-gray-100 rounded shadow">
    <div class="flex justify-between items-center mb-4">
        <button @click="open = true; tareaId = null; tareaNombre = ''; tareaEstado = ''; actionType = 'save'" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Agregar tarea</button>
        
        <button wire:click="exportarTareas" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded flex items-center">
            <i class="fas fa-file-excel mr-2"></i> Exportar a Excel
        </button>
    </div>

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
        <button @click="actionType = tareaId ? 'edit' : 'save'; showConfirmation = true" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
    </div>

    <div x-show="showConfirmation" class="fixed top-0 left-0 w-full h-full flex items-center justify-center bg-gray-800 bg-opacity-50">
        <div class="bg-white rounded-lg shadow-lg p-6 w-1/3">
            <h1 class="text-2xl font-bold mb-4">Confirmar acción</h1>
            <p x-text="actionType === 'delete' ? '¿Está seguro de que desea eliminar la tarea?' : (actionType === 'edit' ? '¿Está seguro de que desea editar la tarea?' : '¿Está seguro de que desea guardar la tarea?')" class="text-gray-700 mb-4"></p>
            <div class="flex justify-end">
                <button @click="showConfirmation = false" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2">Cancelar</button>
                <template x-if="actionType === 'delete'">
                    <button @click="$wire.deleteTarea(tareaToDelete); showConfirmation = false" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                </template>
                <template x-if="actionType === 'edit'">
                    <button @click="$wire.saveTarea(tareaId, tareaNombre, tareaEstado); showConfirmation = false" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                </template>
                <template x-if="actionType === 'save'">
                    <button @click="$wire.saveTarea(null, tareaNombre, tareaEstado); showConfirmation = false" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
                </template>
            </div>
        </div>
    </div>

    <div class="w-full flex justify-end my-4">
        <div class="flex items-center">
            <input type="text" wire:model="busqueda" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            <button wire:click="buscar" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Buscar</button>
        </div>
    </div>

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
                                        <button @click="tareaId = {{ $tarea->id }}; tareaNombre = '{{ $tarea->nombre }}'; tareaEstado = '{{ $tarea->estado }}'; tareaToDelete = {{ $tarea->id }}; actionType = 'edit'; open = true" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                                        <button @click="tareaToDelete = {{ $tarea->id }}; actionType = 'delete'; showConfirmation = true" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
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