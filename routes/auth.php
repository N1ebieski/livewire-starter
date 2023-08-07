<?php

use Illuminate\Support\Facades\Auth;

Auth::routes([
    'verify' => true,
    'register' => false
]);
