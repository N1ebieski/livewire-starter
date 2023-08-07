<?php

use Illuminate\Support\Facades\Route;

Route::get('user', \App\Livewire\Components\Admin\User\IndexComponent::class)
    ->name('user.index');
