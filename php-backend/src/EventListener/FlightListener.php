<?php

namespace App\EventListener;

use App\Entity\Flight;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;


class FlightListener
{
    /**
     * @param LifecycleEventArgs $args
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof Flight) {
            return;
        }

        $gates = $entity->getAirplane()->getAirplaneType()->getGates();
        if (empty($gates) || !in_array($entity->getGate(), $gates->toArray())) {
            throw new \Exception('This airplane could not exist on this gate!');
        }

        if ($entity->getDateOfDeparture() < $entity->getAirplane()->getDateOfProduction()) {
            throw new \Exception('This airplane could not use this airplane!');
        }
    }

    /**
     * @param LifecycleEventArgs $args
     * @throws \Exception
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->prePersist($args);
    }
}
