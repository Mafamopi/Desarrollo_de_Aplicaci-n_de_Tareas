<div x-data="{ open: false, tareaId: null, tareaNombre: '', tareaEstado: '' }" class="container mx-auto mt-5">
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

    <table class="table-auto mt-3">
        <thead class="bg-gray-200">
            <tr>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tareas as $tarea)
                <tr>
                    <td>{{ $tarea->nombre }}</td>
                    <td>{{ $tarea->estado }}</td>
                    <td>
                        <button @click="open = true; tareaId = {{ $tarea->id }}; tareaNombre = '{{ $tarea->nombre }}'; tareaEstado = '{{ $tarea->estado }}'">Editar</button>
                        <button @click="$wire.deleteTarea({{ $tarea->id }})">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
