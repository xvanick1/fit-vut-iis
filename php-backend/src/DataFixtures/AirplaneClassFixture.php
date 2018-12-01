<?php

namespace App\DataFixtures;

use App\Entity\AirplaneClass;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class AirplaneClassFixture extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $airClassBusiness = new AirplaneClass();
        $airClassBusiness->setName('Business');
        $manager->persist($airClassBusiness);
        $this->setReference("businessClass", $airClassBusiness);

        $airClassRelax = new AirplaneClass();
        $airClassRelax->setName('Relax');
        $manager->persist($airClassRelax);
        $this->setReference("RelaxClass", $airClassRelax);

        $airClassEconomy = new AirplaneClass();
        $airClassEconomy->setName('Economy');
        $manager->persist($airClassEconomy);
        $this->setReference("EconomyClass", $airClassEconomy);

        $manager->flush();
    }

}
