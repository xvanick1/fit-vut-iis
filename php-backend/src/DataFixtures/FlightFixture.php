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
        $flight = new Flight();
        $flight->setAirplane($this->getReference("B747"));
        $flight->setDateOfDeparture(new \DateTime());
        $flight->setDestination("Prague");
        $flight->setFlightLength(new \DateTime("11:30:00"));
        $flight->setGate($this->getReference("G1"));
        $flight->setTimeOfDeparture(new \DateTime('12:00:00'));
        $manager->persist($flight);

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
