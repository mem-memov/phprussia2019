<?php

namespace CarSharing;

class Rent
{
    private $database;
    
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    
    public function start(int $userId, int $carId): void
    {
        $user = $this->database->fetch(
            'SELECT card FROM user WHERE id = :id',
            ['id' => $userId]
        );
        
        if ( is_null($user['card']) ) {
            throw new \Exception('User without card');
        }

        $car = $this->database->fetch(
            'SELECT fuel FROM car WHERE id = :id',
            ['id' => $carId]
        );
        
        if ( $car['fuel'] === 0 ) {
            throw new \Exception('Car without fuel');
        }

        $this->database->insert(
            'INSERT INTO rent (car_id, user_id) VALUES (:car_id, :user_id)',
            [':car_id' => $carId, ':user_id' => $userId]
        );
    }
}
