<?php

namespace CarSharing\Rent;

use CarSharing\Database;

class Rent
{
    private $userId;
    private $carId;
    private $database;
    
    public function __construct(int $userId, int $carId, Database $database)
    {
        $this->userId = $userId;
        $this->carId = $carId;
        $this->database = $database;
    }
    
    public function start(): void
    {
        $this->database->insert(
            'INSERT INTO rent (car_id, user_id) VALUES (:car_id, :user_id)',
            [':car_id' => $this->carId, ':user_id' => $this->userId]
        );
    }
}