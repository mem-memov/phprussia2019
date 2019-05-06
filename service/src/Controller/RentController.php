<?php

namespace CarSharing\Controller;

use CarSharing\Container;
use CarSharing\Request;
use CarSharing\Rent\Rents;
use CarSharing\Rent\CheckedRent;

class RentController
{
    private $container;
    
    public function __construct(Container $container)
    {
        $this->container = $container;
    }
    
    public function actionStart(Request $request)
    {
        $userId = $request->get('user_id');
        $carId = $request->get('car_id');
        
        /** @var Rents $rents */
        $rents = $this->container->get('rents');
        
        /** @var CheckedRent $rents */
        $checkedRent = $rents->makeCheckedRent($userId, $carId);
        
        $checkedRent->start();
    }
}
