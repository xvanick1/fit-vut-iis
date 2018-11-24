<?php

namespace App\DataFixtures;


use App\Entity\Airplane;
use App\Entity\AirplaneType;
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

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            GateFixture::class,
        );
    }
}
