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
        $airClass = new AirplaneClass();
        $airClass->setName('Business');
        $manager->persist($airClass);
        $this->setReference("businessClass", $airClass);

        $airClass2 = new AirplaneClass();
        $airClass2->setName('Economy');
        $manager->persist($airClass2);

        $manager->flush();
    }

}
