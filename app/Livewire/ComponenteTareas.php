<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tareas;

class ComponenteTareas extends Component
{

    public $tareas;

    public function mount()
    {
        $this->tareas = Tareas::all();
    }

    public function saveTarea($id, $nombre, $estado)
    {

        if (empty($nombre) || empty($estado)){
            throw new Exception("Los campos de nombre y estado no pueden estar vacios.");            
        }

        if ($id) {
            $tarea = Tareas::find($id);
            $tarea->update(['nombre' => $nombre, 'estado' => $estado]);
        } else {
            Tareas::create(['nombre' => $nombre, 'estado' => $estado]);
        }

        $this->tareas = Tareas::all();
    }

    public function deleteTarea($id)
    {
        Tareas::destroy($id);
        $this->tareas = Tareas::all();
    }
    
    public function render()
    {
        return view('livewire.componente-tareas');
    }
}