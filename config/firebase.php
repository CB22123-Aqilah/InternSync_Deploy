<?php

return [
    'credentials' => [
        'file' => base_path(env('FIREBASE_CREDENTIALS', 'firebase_credentials.json')),
    ],

    'database' => [
        'url' => env('FIREBASE_DATABASE_URL', 'https://console.firebase.google.com/u/0/project/internsync-8baad/database/internsync-8baad-default-rtdb/data'),
    ],
];
