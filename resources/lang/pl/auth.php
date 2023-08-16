<?php

return [
    'pages' => [
        'login' => [
            'title' => 'Zaloguj się',
            'description' => 'Zaloguj się',
            'keywords' => 'zaloguj się',
        ],
        'logout' => [
            'title' => 'Wyloguj się',
        ],
        'reset' => [
            'title' => 'Zresetuj hasło'
        ],
        'register' => [
            'title' => 'Zarejestruj się'
        ],
        'verify' => [
            'title' => 'Potwierdź adres e-mail'
        ]
    ],
    'actions' => [
        'verify' => 'Nowy link weryfikacyjny twojego konta został wysłany na twój adres e-mail.',
        'socialite' => [
            'no_email' => 'Nie mogliśmy zarejestrować Cię używając danych od :provider. Upewnij się, że zezwalasz na udostępnianie nam swojego adresu e-mail w ustawieniach swojego konta w :provider (zakładka Aplikacje) lub wykonaj pełną rejestrację w formularzu poniżej.',
            'no_name' => 'Nie mogliśmy zarejestrować Cię używając danych od :provider. Upewnij się, że zezwalasz na udostępnianie nam swojej nazwu użytkownika w ustawieniach swojego konta w :provider (zakładka Aplikacje) lub wykonaj pełną rejestrację w formularzu poniżej.',
            'email_exist' => 'Istnieje już zarejestrowane konto na podany adres e-mail. Połącz swoje konto z :provider z poziomu edycji profilu po zalogowaniu.'
        ]
    ],
    'failed'   => 'Błędny login lub hasło.',
    'password' => 'Hasło jest nieprawidłowe.',
    'throttle' => 'Za dużo nieudanych prób logowania. Proszę spróbować za :seconds sekund.',
    'hello' => 'Witaj',
    'login_with' => 'Zaloguj się przez',
    'register_with' => 'Zarejestruj się przez',
    'login' => 'Zaloguj się',
    'logout' => 'Wyloguj się',
    'address' => [
        'label' => 'Adres e-mail',
        'placeholder' => 'Wpisz adres e-mail'
    ],
    'password' => 'Hasło',
    'remember' => 'Zapamiętaj mnie',
    'forgot' => 'Zapomniałeś hasła?',
    'no_profile' => 'Nie masz jeszcze konta?',
    'register' => 'Zarejestruj się',
    'reset' => 'Zresetuj hasło',
    'submit_reset' => 'Wyślij link do zmiany hasła',
    'name' => [
        'label' => 'Nazwa użytkownika',
        'placeholder' => 'Wpisz nazwę użytkownika'
    ],
    'password_confirm' => 'Potwierdź hasło',
];
