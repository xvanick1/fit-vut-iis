<?php

namespace App\EventListener;

use App\Entity\Airplane;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;


class AirplaneListener
{
    /**
     * @param LifecycleEventArgs $args
     * @throws \Exception
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Airplane) {
            return;
        }

        $flights = $entity->getFlights();
        foreach ($flights as $flight) {
            if ($flight->getDateOfDeparture() < $entity->getDateOfProduction()) {
                throw new \Exception('This airplane has flights before new date of production!');

            }
        }
    }
}
