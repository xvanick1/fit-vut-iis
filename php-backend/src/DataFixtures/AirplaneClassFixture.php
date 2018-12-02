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
        $airClassMillionaire = new AirplaneClass();
        $airClassMillionaire->setName('Millionaire');
        $manager->persist($airClassMillionaire);
        $this->setReference("millionaireClass", $airClassMillionaire);

        $airClassBusiness = new AirplaneClass();
        $airClassBusiness->setName('Business');
        $manager->persist($airClassBusiness);
        $this->setReference("businessClass", $airClassBusiness);

        $airClassRelax = new AirplaneClass();
        $airClassRelax->setName('Relax');
        $manager->persist($airClassRelax);
        $this->setReference("relaxClass", $airClassRelax);

        $airClassEconomy = new AirplaneClass();
        $airClassEconomy->setName('Economy');
        $manager->persist($airClassEconomy);
        $this->setReference("economyClass", $airClassEconomy);

        $airClassLuxus = new AirplaneClass();
        $airClassLuxus->setName('Luxus');
        $manager->persist($airClassLuxus);

        unset($airClassMillionaire);
        unset($airClassBusiness);
        unset($airClassRelax);
        unset($airClassEconomy);
        unset($airClassLuxus);

        $manager->flush();
        $manager->clear();
    }

}
