<?php
declare(strict_types=1);

return [
    'user1@test.com' => [
        'name' => 'John',
        'password' => '$2y$10$VRFcxoHv1FUarSR3TtpcFOTnkuMyAS2DfNG7C4VGjQiaSFW.KkJfa', //Qwert123 // use password_hash() to generate password in your code
    ],
    'user2@test.com' => [
        'name' => 'Jane',
        'password' => '$2y$10$3bOpL2S7ZyqJxFiKtE5NouiC2Jtic.mMmd0YzqiSu.iw2CeWHjl9S', //User2Jane  // use password_hash() to generate password in your code
    ],
    'test@gmail.com' => [
        'name' => 'Test',
        'password' => '$2y$10$mgklF/zfFVaY0CNs0npJ6eZGQNONu4fzipK.bJzUeva7Eg7jyGFLO', //Test123
    ]
];
