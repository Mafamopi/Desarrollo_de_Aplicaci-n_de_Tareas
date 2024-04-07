<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\ComponenteTareas;

Route::redirect('/', '/componente-tareas');

Route::get('/componente-tareas', ComponenteTareas::class);