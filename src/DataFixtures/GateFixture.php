<?php

namespace App\DataFixtures;


use App\Entity\Gate;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class GateFixture extends Fixture implements DependentFixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     * @throws \Exception
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $gate = new Gate();
            $gate->setName("A".$i);
            $gate->setTerminal($this->getReference("T".random_int(0,4)));
            $manager->persist($gate);
            $this->setReference("G".$i, $gate);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            TerminalFixture::class,
        );
    }
}
