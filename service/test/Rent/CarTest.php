<?php

namespace CarSharing\Rent;

use CarSharing\Database;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    protected $database;
    
    protected function setUp()
    {
        $this->database = $this->createMock(Database::class);
    }
    
    public function testItRequiresFuelWhenTankFull()
    {
        $car = new Car(333, $this->database);
        
        $this->database->expects($this->once())
            ->method('fetch')
            ->with(
                'SELECT fuel FROM car WHERE id = :id',
                ['id' => 333]
            )
            ->willReturn(['fuel' => 35]);
        
        $car->requireFuel();
    }
    
    public function testItRequiresFuelWhenTankEmpty()
    {
        $car = new Car(333, $this->database);
        
        $this->database->expects($this->once())
            ->method('fetch')
            ->with(
                'SELECT fuel FROM car WHERE id = :id',
                ['id' => 333]
            )
            ->willReturn(['fuel' => 0]);
        
        $this->expectException(\Exception::class);
        
        $car->requireFuel();
    }
}
