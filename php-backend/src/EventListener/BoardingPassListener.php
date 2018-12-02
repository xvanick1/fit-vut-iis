<?php

namespace App\EventListener;

use App\Entity\BoardingPass;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;


class BoardingPassListener
{
    /**
     * @param LifecycleEventArgs $args
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof BoardingPass) {
            return;
        }

        // check if seat is empty in this flight
        $flight = $entity->getFlightTicket()->getFlight();
        $seats = $args->getObjectManager()->getRepository(BoardingPass::class)->getSeatsByFlight($flight->getId());
        if (in_array($entity->getSeat()->getId(), $seats)) {
            throw new \Exception('This seat is already assigned!');
        }

        $seats = $flight->getAirplane()->getSeats();
        if (!$seats->contains($entity->getSeat())) {
            throw new \Exception('This seat is not available in this flight!');
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
