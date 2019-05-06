<?php

namespace CarSharing\Rent;

use PHPUnit\Framework\TestCase;

class CheckedRentTest extends TestCase
{
    protected $user;
    protected $car;
    protected $rent;
    
    protected function setUp()
    {
        $this->user = $this->createMock(User::class);
        $this->car = $this->createMock(Car::class);
        $this->rent = $this->createMock(Rent::class);
    }
    
    public function testItStarts()
    {
        $checkedRent = new CheckedRent($this->user, $this->car, $this->rent);
        
        $this->user->expects($this->once())->method('requireBankCard');
        $this->car->expects($this->once())->method('requireFuel');
        $this->rent->expects($this->once())->method('start');
        
        $checkedRent->start();
    }
}