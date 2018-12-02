<?php

namespace App\DataFixtures;


use App\Entity\Terminal;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class TerminalFixture extends Fixture
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 7; $i++) {
            $terminal = new Terminal();
            $terminal->setName("T".$i);
            $manager->persist($terminal);
            $this->addReference("T".$i, $terminal);
            unset($terminal);
        }

        $manager->flush();
        $manager->clear();
    }
}
