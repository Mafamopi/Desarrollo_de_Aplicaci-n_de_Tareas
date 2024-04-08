<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileDownload;
use App\Models\Tareas;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

class ComponenteTareas extends Component
{

    public $tareas;
    public $busqueda = '';

    public function mount()
    {
        $this->tareas = Tareas::all();
    }

    public function saveTarea($tareaId, $tareaNombre, $tareaEstado)
    {
        if (empty($tareaNombre) || empty($tareaEstado)){
            throw new Exception("Los campos de nombre y estado no pueden estar vacíos.");            
        }

        if ($tareaId) {
            $tarea = Tareas::find($tareaId);
            if ($tarea) {
                $tarea->update(['nombre' => $tareaNombre, 'estado' => $tareaEstado]);
            } else {
                throw new Exception("No se encontró la tarea con el ID proporcionado.");
            }
        } else {
            Tareas::create(['nombre' => $tareaNombre, 'estado' => $tareaEstado]);
        }

        $this->tareas = Tareas::all();
        
        $this->tareaId = null;
        $this->tareaNombre = '';
        $this->tareaEstado = '';
    }


    public function deleteTarea($id)
    {
        Tareas::destroy($id);
        $this->tareas = Tareas::all();
    }

    public function buscar()
    {
        if (empty($this->busqueda)) {            
            $this->tareas = Tareas::all();
        }else{
            $this->tareas = Tareas::where('nombre', 'like', '%' . $this->busqueda . '%')->
            orwhere('estado', 'like', '%' . $this->busqueda . '%')->get();
        }
    }

    public function exportarTareas()
    {
        if (empty($this->busqueda)) {
            $data = Tareas::all();
        } else {
            $data = Tareas::where('nombre', 'like', '%' . $this->busqueda . '%')
                ->orWhere('estado', 'like', '%' . $this->busqueda . '%')
                ->get();
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Nombre');
        $sheet->setCellValue('B1', 'Estado');

        $row = 2;
        foreach ($data as $tarea) {
            $sheet->setCellValue('A' . $row, $tarea->nombre);
            $sheet->setCellValue('B' . $row, $tarea->estado);
            $row++;
        }

        $fileName = 'tareas.xlsx';

        $writer = new Xlsx($spreadsheet);
        ob_start();
        $writer->save('php://output');
        $content = ob_get_clean();

        return Response::stream(
            fn () => print($content),
            200,
            [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
            ]
        );
    }

    public function render()
    {
        return view('livewire.componente-tareas');
    }

}
