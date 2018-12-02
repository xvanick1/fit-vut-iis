<?php

namespace App\EventListener;

use App\Entity\FlightTicket;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;


class FlightTicketListener
{
    /**
     * @param LifecycleEventArgs $args
     * @throws \Exception
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if (!$entity instanceof FlightTicket) {
            return;
        }

        $countOfTickets = $args->getObjectManager()->getRepository(FlightTicket::class)->countTicketsOnFlightByClass($entity->getFlight()->getId(), $entity->getAirplaneClass()->getId());
        $seats = $entity->getFlight()->getAirplane()->getSeats();
        $airplaneClasses = [];
        foreach ($seats as $seat) {
            if (!key_exists($seat->getAirplaneClass()->getId(), $airplaneClasses)) {
                $airplaneClasses[$seat->getAirplaneClass()->getId()] = 0;
            }
            $airplaneClasses[$seat->getAirplaneClass()->getId()] += 1;
        }

        if  (key_exists($entity->getAirplaneClass()->getId(), $airplaneClasses)) {
          if ($countOfTickets > count($airplaneClasses[$entity->getAirplaneClass()->getId()])) {
            throw new \Exception('This flight is full in this class!');
          }
        } else {
            throw new \Exception('This flight has not this class!');
        }
    }
}
