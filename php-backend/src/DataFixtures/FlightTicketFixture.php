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
        $ticket1 = new FlightTicket();
        $ticket1->setName('Pavel');
        $ticket1->setSurname('Witassek');
        $ticket1->setAirplaneClass($this->getReference('economyClass'));
        $ticket1->setFlight($this->getReference('PRG'));
        $manager->persist($ticket1);

        $ticket2 = new FlightTicket();
        $ticket2->setName('Jan');
        $ticket2->setSurname('Novák');
        $ticket2->setAirplaneClass($this->getReference('economyClass'));
        $ticket2->setFlight($this->getReference('PRG'));
        $manager->persist($ticket2);

        $ticket3 = new FlightTicket();
        $ticket3->setName('Tomáš');
        $ticket3->setSurname('Lecko');
        $ticket3->setAirplaneClass($this->getReference('businessClass'));
        $ticket3->setFlight($this->getReference('PRG'));
        $manager->persist($ticket3);

        $ticket4 = new FlightTicket();
        $ticket4->setName('Abdiás');
        $ticket4->setSurname('Ferdinánd');
        $ticket4->setAirplaneClass($this->getReference('economyClass'));
        $ticket4->setFlight($this->getReference('BUD'));
        $manager->persist($ticket4);

        $ticket5 = new FlightTicket();
        $ticket5->setName('Petr');
        $ticket5->setSurname('Luhánek');
        $ticket5->setAirplaneClass($this->getReference('economyClass'));
        $ticket5->setFlight($this->getReference('SVO'));
        $manager->persist($ticket5);

        $ticket6 = new FlightTicket();
        $ticket6->setName('Tomáš');
        $ticket6->setSurname('Frigyik');
        $ticket6->setAirplaneClass($this->getReference('relaxClass'));
        $ticket6->setFlight($this->getReference('BGY'));
        $manager->persist($ticket6);

        $ticket7 = new FlightTicket();
        $ticket7->setName('Martin');
        $ticket7->setSurname('Kraus');
        $ticket7->setAirplaneClass($this->getReference('relaxClass'));
        $ticket7->setFlight($this->getReference('JFK'));
        $manager->persist($ticket7);

        $ticket8 = new FlightTicket();
        $ticket8->setName('Nina');
        $ticket8->setSurname('Karašenko');
        $ticket8->setAirplaneClass($this->getReference('economyClass'));
        $ticket8->setFlight($this->getReference('KEF'));
        $manager->persist($ticket8);

        $ticket9 = new FlightTicket();
        $ticket9->setName('Alica');
        $ticket9->setSurname('Frad');
        $ticket9->setAirplaneClass($this->getReference('economyClass'));
        $ticket9->setFlight($this->getReference('KEF'));
        $manager->persist($ticket9);

        $ticket10 = new FlightTicket();
        $ticket10->setName('Samuel');
        $ticket10->setSurname('Suchánek');
        $ticket10->setAirplaneClass($this->getReference('economyClass'));
        $ticket10->setFlight($this->getReference('BGY'));
        $manager->persist($ticket10);

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
