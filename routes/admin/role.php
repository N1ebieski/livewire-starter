<?php

use Illuminate\Support\Facades\Route;

Route::get('roles', \App\Livewire\Components\Admin\Role\IndexComponent::class)
    ->name('role.index')
    ->middleware('permission:admin.role.view');
