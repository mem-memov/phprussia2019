<?php

namespace CarSharing\Rent;

use CarSharing\Database;

class User
{
private $id;
private $database;

public function __construct(int $id, Database $database)
{
    $this->id = $id;
    $this->database = $database;
}
    
    public function requireBankCard(): void
    {
        $user = $this->database->fetch(
            'SELECT card FROM user WHERE id = :id',
            ['id' => $this->id]
        );
        
        if ( is_null($user['card']) ) {
            throw new \Exception('User without card');
        }
    }
}
