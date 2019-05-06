<?php

namespace CarSharing\Controller;

use CarSharing\Container;
use CarSharing\Request;
use CarSharing\Rent\Rents;
use CarSharing\Rent\CheckedRent;
use PHPUnit\Framework\TestCase;

class RentControllerTest extends TestCase
{
    protected $container;
    
    protected function setUp()
    {
        $this->container = $this->createMock(Container::class);
    }
    
    public function testItStartsRent()
    {
        $rent = new RentController($this->container);
        
        $request = $this->createMock(Request::class);
        
        $request->expects($this->at(0))
            ->method('get')
            ->with('user_id')
            ->willReturn(12);
        
        $request->expects($this->at(1))
            ->method('get')
            ->with('car_id')
            ->willReturn(333);
        
        $rents = $this->createMock(Rents::class);
        
        $this->container->expects($this->once())
            ->method('get')
            ->with('rents')
            ->willReturn($rents);
        
        $checkedRent = $this->createMock(CheckedRent::class);
        
        $rents->expects($this->once())
            ->method('makeCheckedRent')
            ->with(12, 333)
            ->willReturn($checkedRent);

        $checkedRent->expects($this->once())
            ->method('start');

        $rent->actionStart($request);
    }
}
