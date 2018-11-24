<?php

namespace App\EventListener;

use App\Entity\AirplaneType;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;

class AirplaneTypeListener
{
    /**
     * @param LifecycleEventArgs $args
     * @throws \Exception
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof AirplaneType) {
            return;
        }

        $gates = $entity->getGates();
        $airplanes = $entity->getAirplanes();

        foreach ($airplanes as $airplane) {
            $airFlights = $airplane->getFlights();
            foreach ($airFlights as $flight) {
                if (!in_array($flight->getGate(), $gates->toArray())) {
                    throw new \Exception('Exists flights on this gate');
                }
            }
        }
    }
}
