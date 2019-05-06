<?php

namespace CarSharing\Rent;

use CarSharing\Database;

class Rents
{
    private $database;
    
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    
    public function makeCheckedRent(int $userId, int $carId): CheckedRent
    {
        return new CheckedRent(
            new User($userId, $this->database),
            new Car($carId, $this->database),
            new Rent($userId, $carId, $this->database)
        );
    }
}

