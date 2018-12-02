<?php

namespace App\DataFixtures;


use App\Entity\FlightTicket;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FlightTicketFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $ticket = new FlightTicket();
        $ticket->setName('Pavel');
        $ticket->setSurname('Witassek');
        $ticket->setAirplaneClass($this->getReference('economyClass'));
        $ticket->setFlight($this->getReference('PRG'));
        $manager->persist($ticket);

        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [
            FlightFixture::class
        ];
    }
}
