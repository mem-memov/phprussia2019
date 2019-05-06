<?php

namespace CarSharing\Rent;

use CarSharing\Database;
use PHPUnit\Framework\TestCase;

class RentTest extends TestCase
{
    protected $database;
    
    protected function setUp()
    {
        $this->database = $this->createMock(Database::class);
    }
    
    public function testItStarts()
    {
        $rent = new Rent(1, 2, $this->database);
        
        $this->database->expects($this->once())
            ->method('insert')
            ->with(
                'INSERT INTO rent (car_id, user_id) VALUES (:car_id, :user_id)',
                [':car_id' => 2, ':user_id' => 1]
            );
        
        $rent->start();
    }
}