<?php

namespace CarSharing\Rent;

use CarSharing\Database;

class Car
{
    private $id;
    private $database;
    
    public function __construct(int $id, Database $database)
    {
        $this->id = $id;
        $this->database = $database;
    }
    
    public function requireFuel(): void
    {
        $car = $this->database->fetch(
            'SELECT fuel FROM car WHERE id = :id',
            ['id' => $this->id]
        );
        
        if ( $car['fuel'] === 0 ) {
            throw new \Exception('Car without fuel');
        }
    }
}
