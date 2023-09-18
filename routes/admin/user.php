<?php

use Illuminate\Support\Facades\Route;

Route::get('users', \App\Livewire\Components\Admin\User\IndexComponent::class)
    ->name('user.index')
    ->middleware('permission:admin.users.view');
