<?php

namespace CarSharing\Rent;

class CheckedRent
{
    private $user;
    private $car;
    private $rent;
    
    public function __construct(User $user, Car $car, Rent $rent)
    {
        $this->user = $user;
        $this->car = $car;
        $this->rent = $rent;
    }
    
    public function start(): void
    {
        $this->user->requireBankCard();
        $this->car->requireFuel();
        $this->rent->start();
    }
}
