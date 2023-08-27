<?php

declare(strict_types=1);

return [
    'pages' => [
        'index' => [
            'title' => 'Role i uprawnienia',
            'description' => 'Role i uprawnienia',
            'keywords' => 'Role i uprawnienia'
        ],
        'create' => [
            'title' => 'Dodaj role'
        ],
        'edit' => [
            'title' => 'Edycja roli: :name'
        ]
    ],
    'actions' => [
        'delete' => [
            'single' => 'Pomyślnie usunięto rolę :name',
            'multi' => '{1} Pomyślnie usunięto :number rolę|{2,4} Pomyślnie usunięto :number role|{4,*} Pomyślnie usunięto :number ról'
        ],
        'create' => 'Pomyślnie dodano rolę :name',
        'edit' => 'Pomyślnie edytowano rolę :name',
    ],
    'confirms' => [
        'delete' => [
            'single' => 'Czy na pewno chcesz usunąć rolę :name?',
            'multi' => '{1} Czy na pewno chcesz usunąć :number rolę?|{2,4} Czy na pewno chcesz usunąć :number role?|{4,*} Czy na pewno chcesz usunąć :number ról?'
        ]
    ],
    'name' => [
        'label' => 'Nazwa'
    ],
    'permissions' => [
        'label' => 'Uprawnienia'
    ]
];
