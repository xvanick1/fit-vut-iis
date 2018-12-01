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
        /* Testing fixture */
        /*
        $airType = new AirplaneType();
        $airType->setName("747");
        $airType->setManufacturer("Boeing");
        $airType->addGate($this->getReference('G1'));
        $airType->addGate($this->getReference('G2'));
        $airType->addGate($this->getReference('G3'));
        $airType->addGate($this->getReference('G4'));
        $manager->persist($airType);

        $airplane = new Airplane();
        $airplane->setCrewNumber(5);
        $airplane->setDateOfProduction(new \DateTime());
        $airplane->setDateOfRevision(new \DateTime());
        $airplane->setAirplaneType($airTypeB747);
        $manager->persist($airplane);
        $this->setReference("B747", $airplane);
        */

        /* Boeing */
        $airTypeB737 = new AirplaneType();
        $airTypeB737->setName("737");
        $airTypeB737->setManufacturer("Boeing");
        $airTypeB737->addGate($this->getReference('G1'));
        $airTypeB737->addGate($this->getReference('G2'));
        $airTypeB737->addGate($this->getReference('G3'));
        $airTypeB737->addGate($this->getReference('G4'));
        $manager->persist($airTypeB737);

        for ($i = 0; $i < 2; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(2, 7));
            $airplane->setDateOfProduction(new \DateTime());
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeB737);
            $manager->persist($airplane);
            $this->setReference("B737", $airplane);
        }

        $numberOfSeats = 0;
        $maxClassSeats = 12;
        for ($i = 1; $i <= $maxClassSeats; $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('businessClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }
        $maxClassSeats = 24;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('relaxClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }
        $maxClassSeats = 48;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('economyClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }



        $airTypeB747 = new AirplaneType();
        $airTypeB747->setName("747");
        $airTypeB747->setManufacturer("Boeing");
        $airTypeB747->addGate($this->getReference('G1'));
        $airTypeB747->addGate($this->getReference('G2'));
        $airTypeB747->addGate($this->getReference('G3'));
        $airTypeB747->addGate($this->getReference('G4'));
        $manager->persist($airTypeB747);

        for ($i = 0; $i < 3; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(1, 7));
            $airplane->setDateOfProduction(new \DateTime());
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeB747);
            $manager->persist($airplane);
            $this->setReference("B747", $airplane);
        }

        $numberOfSeats = 0;
        $maxClassSeats = 6;
        for ($i = 1; $i <= $maxClassSeats; $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('businessClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }
        $maxClassSeats = 18;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('relaxClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }
        $maxClassSeats = 30;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('economyClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }



        $airTypeB767 = new AirplaneType();
        $airTypeB767->setName("767");
        $airTypeB767->setManufacturer("Boeing");
        $airTypeB767->addGate($this->getReference('G3'));
        $airTypeB767->addGate($this->getReference('G4'));
        $airTypeB767->addGate($this->getReference('G5'));
        $manager->persist($airTypeB767);

        for ($i = 0; $i < 2; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(1, 7));
            $airplane->setDateOfProduction(new \DateTime());
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeB767);
            $manager->persist($airplane);
            $this->setReference("B767", $airplane);
        }

        $numberOfSeats = 0;
        $maxClassSeats = 6;
        for ($i = 1; $i <= $maxClassSeats; $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('businessClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }
        $maxClassSeats = 12;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('relaxClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }
        $maxClassSeats = 24;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('economyClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }



        $airTypeB777 = new AirplaneType();
        $airTypeB777->setName("777");
        $airTypeB777->setManufacturer("Boeing");
        $airTypeB777->addGate($this->getReference('G5'));
        $airTypeB777->addGate($this->getReference('G6'));
        $airTypeB777->addGate($this->getReference('G7'));
        $airTypeB777->addGate($this->getReference('G8'));
        $manager->persist($airTypeB777);

        for ($i = 0; $i < 3; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(1, 7));
            $airplane->setDateOfProduction(new \DateTime());
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeB777);
            $manager->persist($airplane);
            $this->setReference("B777", $airplane);
        }

        $numberOfSeats = 0;
        $maxClassSeats = 24;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('relaxClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }
        $maxClassSeats = 54;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('economyClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }



        $airTypeB787 = new AirplaneType();
        $airTypeB787->setName("787");
        $airTypeB787->setManufacturer("Boeing");
        $airTypeB787->addGate($this->getReference('G1'));
        $airTypeB787->addGate($this->getReference('G2'));
        $airTypeB787->addGate($this->getReference('G5'));
        $manager->persist($airTypeB787);

        for ($i = 0; $i < 1; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(1, 7));
            $airplane->setDateOfProduction(new \DateTime());
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeB787);
            $manager->persist($airplane);
            $this->setReference("B787", $airplane);
        }

        $numberOfSeats = 0;
        $maxClassSeats = 90;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('economyClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }

        /* Airbus */
        $airTypeA320 = new AirplaneType();
        $airTypeA320->setName("320");
        $airTypeA320->setManufacturer("Airbus");
        $airTypeA320->addGate($this->getReference('G1'));
        $airTypeA320->addGate($this->getReference('G2'));
        $airTypeA320->addGate($this->getReference('G5'));
        $manager->persist($airTypeA320);

        for ($i = 0; $i < 1; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(1, 7));
            $airplane->setDateOfProduction(new \DateTime());
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeA320);
            $manager->persist($airplane);
            $this->setReference("A320", $airplane);
        }

        $numberOfSeats = 0;
        $maxClassSeats = 72;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('economyClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }



        $airTypeA330 = new AirplaneType();
        $airTypeA330->setName("330");
        $airTypeA330->setManufacturer("Airbus");
        $airTypeA330->addGate($this->getReference('G1'));
        $airTypeA330->addGate($this->getReference('G2'));
        $airTypeA330->addGate($this->getReference('G3'));
        $airTypeA330->addGate($this->getReference('G4'));
        $manager->persist($airTypeA330);

        for ($i = 0; $i < 2; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(2, 7));
            $airplane->setDateOfProduction(new \DateTime());
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeA330);
            $manager->persist($airplane);
            $this->setReference("A330", $airplane);
        }

        $numberOfSeats = 0;
        $maxClassSeats = 12;
        for ($i = 1; $i <= $maxClassSeats; $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('businessClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }
        $maxClassSeats = 24;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('relaxClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }
        $maxClassSeats = 60;
        for ($i = 1; $i <= ($maxClassSeats + $numberOfSeats); $i++) {
            $seat = new Seat();
            $seat->setAirplane($airplane);
            $seat->setAirplaneClass($this->getReference('economyClass'));
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i);
            $manager->persist($seat);
            $numberOfSeats = $i;
        }

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
