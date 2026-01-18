<?php

namespace App\Models;

use Kreait\Firebase\Factory;

class Guest
{
    protected $database;
    protected $table = 'internship_industries'; // Firebase collection name

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $this->database = $firebase->createDatabase();
    }

    public function store(array $data)
    {
        $newGuestRef = $this->database->getReference($this->table)->push($data);
        return $newGuestRef->getKey();
    }

    public function all()
    {
        $snapshot = $this->database->getReference($this->table)->getSnapshot();
        return $snapshot->getValue() ?: [];
    }
}
