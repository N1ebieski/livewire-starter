<?php

declare(strict_types=1);

use App\Filters\User\StatusEmail;

return [
    'page' => [
        'index' => [
            'title' => 'Użytkownicy',
            'description' => 'Użytkownicy',
            'keywords' => 'Użytkownicy'
        ],
    ],
    'email_verified_at' => 'Data weryfikacji adresu email',
    'email' => [
        'label' => 'Adres email'
    ],
    'status_email' => [
        'label' => 'Status weryfikacji',
        StatusEmail::VERIFIED->value => 'zweryfikowane',
        StatusEmail::UNVERIFIED->value => 'niezweryfikowane'
    ],
    'name' => [
        'label' => 'Nazwa'
    ],
];
