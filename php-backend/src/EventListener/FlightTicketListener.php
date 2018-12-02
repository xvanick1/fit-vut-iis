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
            if (!in_array($seat->getAirplaneClass()->getId(), $airplaneClasses)) {
                $airplaneClasses[$seat->getAirplaneClass()->getId()] = 0;
            }
            $airplaneClasses[$seat->getAirplaneClass()->getId()] += 1;
        }

        if  (in_array($entity->getAirplaneClass()->getId(), $airplaneClasses) && $countOfTickets > count($airplaneClasses[$entity->getAirplaneClass()->getId()])) {
            throw new \Exception('This flight is full in this class!');
        }
    }
}
