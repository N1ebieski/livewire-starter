<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

Route::group([
    'middleware' => 'auth',
    'prefix' => Config::get('custom.routes.web.user.prefix')
], function () {
    Route::get('account', \App\Livewire\Components\Web\User\Account\IndexComponent::class)
        ->name('user.account.index');
});
