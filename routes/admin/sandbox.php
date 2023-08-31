<?php

use Illuminate\Support\Facades\Route;

Route::get('sandbox', \App\Livewire\Components\Admin\Sandbox\IndexComponent::class)
    ->name('sandbox.index')
    ->middleware('permission:admin.home.view');
