<?php

namespace CarSharing\Rent;

use CarSharing\Database;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    protected $database;
    
    protected function setUp()
    {
        $this->database = $this->createMock(Database::class);
    }
    
    public function testItRequiresBankCardWhenPresent()
    {
        $user = new User(12, $this->database);
        
        $this->database->expects($this->once())
            ->method('fetch')
            ->with(
                'SELECT card FROM user WHERE id = :id',
                ['id' => 12]
            )
            ->willReturn(['card' => '1111...4444']);
        
        $user->requireBankCard();
    }
    
    public function testItRequiresBankCardWhenMissing()
    {
        $user = new User(12, $this->database);
        
        $this->database->expects($this->once())
            ->method('fetch')
            ->with(
                'SELECT card FROM user WHERE id = :id',
                ['id' => 12]
            )
            ->willReturn(['card' => null]);
        
        $this->expectException(\Exception::class);
        
        $user->requireBankCard();
    }
}
