<?php

namespace CarSharing;

use PHPUnit\Framework\TestCase;

class RentTest extends TestCase
{
    public function testItStarts()
    {
        $database = $this->createMock(Database::class);
        
        $rent = new Rent($database);
        
        $userId = 1;
        $carId = 2;
        
        $database->expects($this->once())
            ->method('fetchRow')
            ->with(
                'SELECT card FROM user WHERE id = :id',
                ['id' => $userId]
            )
            ->willReturn(['card' => '1111...4444']);

        $database->expects($this->once())
            ->method('fetchRow')
            ->with(
                'SELECT fuel FROM car WHERE id = :id',
                ['id' => $carId]
            )
            ->willReturn(['fuel' => 20]);
        
        $database->expects($this->once())
            ->method('insert')
            ->with(
                'INSERT INTO rent (car_id, user_id) VALUES (:car_id, :user_id)',
                [':car_id' => $carId, ':user_id' => $userId]
            );
        
        $rent->start($userId, $carId);
    }
    
    public function testItFailsToStartWithoutBankCard()
    {
        $database = $this->createMock(Database::class);
        
        $rent = new Rent($database);
        
        $userId = 1;
        $carId = 2;
        
        $database->expects($this->once())
            ->method('fetchRow')
            ->with(
                'SELECT card FROM user WHERE id = :id',
                ['id' => $userId]
            )
            ->willReturn(['card' => null]);

        $this->expectException(\Exception::class);
        
        $rent->start($userId, $carId);
    }
    
    public function testItFailsToStartWithoutFuel()
    {
        $database = $this->createMock(Database::class);
        
        $rent = new Rent($database);
        
        $userId = 1;
        $carId = 2;
        
        $database->expects($this->once())
            ->method('fetchRow')
            ->with(
                'SELECT card FROM user WHERE id = :id',
                ['id' => $userId]
            )
            ->willReturn(['card' => '1111...4444']);

        $database->expects($this->once())
            ->method('fetchRow')
            ->with(
                'SELECT fuel FROM car WHERE id = :id',
                ['id' => $carId]
            )
            ->willReturn(['fuel' => 0]);

        $this->expectException(\Exception::class);
        
        $rent->start($userId, $carId);
    }
}