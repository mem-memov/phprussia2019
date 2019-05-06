<?php

namespace CarSharing\Rent;

use CarSharing\Database;
use PHPUnit\Framework\TestCase;

class RentsTest extends TestCase
{
    protected $database;
    
    protected function setUp()
    {
        $this->database = $this->createMock(Database::class);
    }
    
    public function testItMakesCheckedRent()
    {
        $rents = new Rents($this->database);
        
        $result = $rents->makeCheckedRent(12, 333);
        
        $this->assertInstanceOf(CheckedRent::class, $result);
    }
}

