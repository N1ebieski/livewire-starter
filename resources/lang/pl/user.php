<?php

declare(strict_types=1);

use App\ValueObjects\User\StatusEmail;

return [
    'title' => 'Panel użytkownika',
    'pages' => [
        'index' => [
            'title' => 'Użytkownicy',
            'description' => 'Użytkownicy',
            'keywords' => 'Użytkownicy'
        ],
        'create' => [
            'title' => 'Dodaj użytkownika'
        ],
        'edit' => [
            'title' => 'Edycja użytkownika: :name'
        ],
        'search' => [
            'title' => 'Szukaj użytkownika'
        ]
    ],
    'messages' => [
        'delete' => [
            'single' => 'Pomyślnie usunięto użytkownika :name',
            'multi' => '{1} Pomyślnie usunięto :number użytkownika|{2,*} Pomyślnie usunięto :number użytkowników'
        ],
        'create' => 'Pomyślnie dodano użytkownika :name',
        'edit' => 'Pomyślnie edytowano użytkownika :name',
        'toggle_status_email' => [
            StatusEmail::VERIFIED->value => 'Pomyślnie zweryfikowano adres email :email użytkownika :name'
        ],
    ],
    'confirms' => [
        'delete' => [
            'single' => 'Czy na pewno chcesz usunąć użytkownika :name?',
            'multi' => '{1} Czy na pewno chcesz usunąć :number użytkownika?|{2,*} Czy na pewno chcesz usunąć :number użytkowników?'
        ]
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
    'password' => [
        'label' => 'Hasło'
    ],
    'password_confirmation' => [
        'label' => 'Potwierdź hasło'
    ],
    'roles' => [
        'label' => 'Typ konta'
    ]
];
