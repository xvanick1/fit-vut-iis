<?php

namespace App\DataFixtures;


use App\Entity\Airplane;
use App\Entity\AirplaneClass;
use App\Entity\AirplaneType;
use App\Entity\Seat;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class AirplaneFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $airType = new AirplaneType();
        $airType->setName("747");
        $airType->setManufacturer("Boeing");
        $airType->addGate($this->getReference('G1'));
        $manager->persist($airType);

        $airplane = new Airplane();
        $airplane->setCrewNumber(5);
        $airplane->setDateOfProduction(new \DateTime());
        $airplane->setDateOfRevision(new \DateTime());
        $airplane->setAirplaneType($airType);
        $manager->persist($airplane);
        $this->setReference("B747", $airplane);

        $seat = new Seat();
        $seat->setAirplane($airplane);
        $seat->setAirplaneClass($this->getReference('businessClass'));
        $seat->setLocation('ulička');
        $seat->setSeatNumber(1);
        $manager->persist($seat);

        $seat2 = new Seat();
        $seat2->setAirplane($airplane);
        $seat2->setAirplaneClass($this->getReference('businessClass'));
        $seat2->setLocation('ulička');
        $seat2->setSeatNumber(2);
        $manager->persist($seat2);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            GateFixture::class,
            AirplaneClassFixture::class
        );
    }
}
