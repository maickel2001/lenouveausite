<?php
// Basic configuration with environment overrides
return [
    'site_name' => getenv('SITE_NAME') ?: 'SMM Premium',
    'base_url' => rtrim(getenv('https://giftcardbn.shop/') ?: '/', '/'),

    'db' => [
        'host' => getenv('DB_HOST') ?: 'localhost',
        'name' => getenv('DB_NAME') ?: 'u634930929_Ino',
        'user' => getenv('DB_USER') ?: 'u634930929_Ino',
        'pass' => getenv('DB_PASS') ?: 'Ino1234@',
        'charset' => 'utf8mb4',
    ],

    'mail' => [
        'from' => getenv('MAIL_FROM') ?: 'no-reply@example.com',
        'bcc' => getenv('MAIL_BCC') ?: '',
        'return_path' => getenv('MAIL_RETURN_PATH') ?: '',
    ],

    'theme' => [
        'primary_color' => getenv('PRIMARY_COLOR') ?: '#ff7a00',
        'dark_background' => '#0f0f10',
        'dark_surface' => '#151517',
        'light_text' => '#f5f5f7',
        'muted_text' => '#b3b3b3',
    ],

    'maintenance' => filter_var(getenv('MAINTENANCE_MODE') ?: 'false', FILTER_VALIDATE_BOOLEAN),
];
