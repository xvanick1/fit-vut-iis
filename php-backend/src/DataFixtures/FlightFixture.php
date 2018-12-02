<?php

namespace App\DataFixtures;


use App\Entity\Flight;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class FlightFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $flight1 = new Flight();
        $flight1->setAirplane($this->getReference("B747-1"));
        $flight1->setDateOfDeparture(new \DateTime());
        $flight1->setDestination("Prague: PRG");
        $flight1->setFlightLength(new \DateTime("01:15:00"));
        $flight1->setGate($this->getReference("G1"));
        $flight1->setTimeOfDeparture(new \DateTime('12:00:00'));
        $manager->persist($flight1);
        $this->addReference('PRG', $flight1);

        $flight2 = new Flight();
        $flight2->setAirplane($this->getReference("B747-2"));
        $flight2->setDateOfDeparture(new \DateTime());
        $flight2->setDestination("Moscow: SVO");
        $flight2->setFlightLength(new \DateTime("01:50:00"));
        $flight2->setGate($this->getReference("G3"));
        $flight2->setTimeOfDeparture(new \DateTime('12:10:00'));
        $manager->persist($flight2);

        $flight3 = new Flight();
        $flight3->setAirplane($this->getReference("B737-1"));
        $flight3->setDateOfDeparture(new \DateTime());
        $flight3->setDestination("Bergamo: BGY");
        $flight3->setFlightLength(new \DateTime("01:40:00"));
        $flight3->setGate($this->getReference("G4"));
        $flight3->setTimeOfDeparture(new \DateTime('13:53:00'));
        $manager->persist($flight3);

        $flight4 = new Flight();
        $flight4->setAirplane($this->getReference("A320-3"));
        $flight4->setDateOfDeparture(new \DateTime());
        $flight4->setDestination("Reykjavík: KEF");
        $flight4->setFlightLength(new \DateTime("03:00:00"));
        $flight4->setGate($this->getReference("G5"));
        $flight4->setTimeOfDeparture(new \DateTime('15:08:00'));
        $manager->persist($flight4);

        $flight5 = new Flight();
        $flight5->setAirplane($this->getReference("A380-1"));
        $flight5->setDateOfDeparture(new \DateTime());
        $flight5->setDestination("New York: JFK");
        $flight5->setFlightLength(new \DateTime("05:45:00"));
        $flight5->setGate($this->getReference("G2"));
        $flight5->setTimeOfDeparture(new \DateTime('15:15:00'));
        $manager->persist($flight5);

        $flight6 = new Flight();
        $flight6->setAirplane($this->getReference("A320-1"));
        $flight6->setDateOfDeparture(new \DateTime());
        $flight6->setDestination("Budapest: BUD");
        $flight6->setFlightLength(new \DateTime("01:10:00"));
        $flight6->setGate($this->getReference("G1"));
        $flight6->setTimeOfDeparture(new \DateTime('19:19:00'));
        $manager->persist($flight6);

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
            GateFixture::class,
            AirplaneFixture::class,
        ];
    }
}
