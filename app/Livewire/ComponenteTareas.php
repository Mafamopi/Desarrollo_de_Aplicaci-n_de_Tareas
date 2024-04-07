<?php

namespace App\Livewire;

use Livewire\WithFileDownload;
use Livewire\Component;
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
