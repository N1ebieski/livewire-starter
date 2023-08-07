<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\Components\Admin\Home\IndexComponent::class)
    ->name('home.index');
