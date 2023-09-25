<?php

declare(strict_types=1);

return [
    'pages' => [
        'index' => [
            'title' => 'Konto',
            'description' => 'Konto',
            'keywords' => 'Konto'
        ],
        'change_email' => [
            'title' => 'Zmień adres email'
        ]
    ],
    'actions' => [
        'account' => 'Pomyślnie edytowano dane użytkownika :name',
        'change_password' => 'Pomyslnie wysłano wiadomość e-mail z linkiem do zmiany hasła',
        'change_email' => 'Pomyslnie edytowano adres email przypisany do użytkownika :name'
    ],
    'confirms' => [
        'change_password' => 'Czy na pewno chcesz zmienić hasło?',
    ],
    'change_password' => 'Wyślij wiadomość e-mail z linkiem do zmiany hasła',
    'change_email' => 'Przejdź do formularza zmiany adresu e-mail'
];
