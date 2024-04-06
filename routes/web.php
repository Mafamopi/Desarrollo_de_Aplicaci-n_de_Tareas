<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ComponenteTareas;
 
Route::get('/', function () {
    return view('welcome');
});

Route::get('/componente-tareas', ComponenteTareas::class);