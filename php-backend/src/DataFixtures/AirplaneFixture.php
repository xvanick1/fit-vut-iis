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
    private $batchSize = 20;
    private $actualSeat = 0;
    private $em;

    private function generateSeats($numberOfSeats, $airplane, AirplaneClass $airClass) {
        for ($i = 1; $i <= $numberOfSeats; $i++) {
            $seat = new Seat();
            $seat->setAirplane($this->getReference($airplane));
            $seat->setAirplaneClass($airClass);
            if($i % 6 == 1 || (($i % 6 == 0) && ($i % 3 == 0))) {
                $seat->setLocation('okno');
            }
            if(($i % 6 == 2) || ($i % 6 == 5)){
                $seat->setLocation('střed');
            }
            if(($i % 3 == 0) && ($i % 6 != 0) || ($i % 6 == 4)){
                $seat->setLocation('ulička');
            }
            $seat->setSeatNumber($i+$this->actualSeat);
            $this->em->persist($seat);
            unset($seat);

            if (($i % $this->batchSize) === 0) {
                $this->em->flush();
            }
        }

        $this->actualSeat += $numberOfSeats;
        $this->em->flush();
    }

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $this->em = $manager;

        /* Boeing 737 */
        $airTypeB737 = new AirplaneType();
        $airTypeB737->setName("737");
        $airTypeB737->setManufacturer("Boeing");
        $airTypeB737->addGate($this->getReference('G1'));
        $airTypeB737->addGate($this->getReference('G2'));
        $airTypeB737->addGate($this->getReference('G3'));
        $airTypeB737->addGate($this->getReference('G4'));
        $this->em->persist($airTypeB737);

        for ($i = 0; $i < 2; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(2, 7));
            $airplane->setDateOfProduction(new \DateTime());
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeB737);
            $this->addReference('B737-'.$i, $airplane);
            $this->em->persist($airplane);
            if ($i == 0) {
                $this->generateSeats(12, "B737-" . $i, $this->getReference('businessClass'));
            }
            $this->generateSeats(18, "B737-".$i, $this->getReference('relaxClass'));
            $this->generateSeats(30, "B737-".$i, $this->getReference('economyClass'));
            $this->actualSeat = 0;
        }
        $this->em->flush();
        $this->em->clear();

        /* Boeing 747 */
        $airTypeB747 = new AirplaneType();
        $airTypeB747->setName("747");
        $airTypeB747->setManufacturer("Boeing");
        $airTypeB747->addGate($this->getReference('G1'));
        $airTypeB747->addGate($this->getReference('G3'));
        $this->em->persist($airTypeB747);
        for ($i = 0; $i < 3; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(3, 7));
            $airplane->setDateOfProduction(new \DateTime());
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeB747);
            $this->em->persist($airplane);
            $this->addReference("B747-".$i, $airplane);
            $this->generateSeats(12, "B747-".$i, $this->getReference('businessClass'));
            if ($i == 2) {
                $this->generateSeats(24, "B747-" . $i, $this->getReference('relaxClass'));
            }
            $this->generateSeats(42, "B747-".$i, $this->getReference('economyClass'));
            $this->actualSeat = 0;
        }
        $this->em->flush();
        $this->em->clear();

        /* Boeing 787 */
        $airTypeB787 = new AirplaneType();
        $airTypeB787->setName("787");
        $airTypeB787->setManufacturer("Boeing");
        $airTypeB787->addGate($this->getReference('G1'));
        $airTypeB787->addGate($this->getReference('G4'));
        $airTypeB787->addGate($this->getReference('G5'));
        $manager->persist($airTypeB787);
        for ($i = 0; $i < 1; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(1, 7));
            $airplane->setDateOfProduction(new \DateTime());
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeB787);
            $manager->persist($airplane);
            $this->addReference("B787-".$i, $airplane);
            $this->generateSeats(18, "B787-".$i, $this->getReference('businessClass'));
            $this->generateSeats(24, "B787-" . $i, $this->getReference('relaxClass'));
            $this->generateSeats(36, "B787-".$i, $this->getReference('economyClass'));
            $this->actualSeat = 0;
        }
        $this->em->flush();
        $this->em->clear();

        /* Airbus A320 */
        $airTypeA320 = new AirplaneType();
        $airTypeA320->setName("320");
        $airTypeA320->setManufacturer("Airbus");
        $airTypeA320->addGate($this->getReference('G1'));
        $airTypeA320->addGate($this->getReference('G2'));
        $airTypeA320->addGate($this->getReference('G5'));
        $manager->persist($airTypeA320);

        for ($i = 0; $i < 4; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(2, 7));
            $airplane->setDateOfProduction(new \DateTime('last day of last month'));
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeA320);
            $manager->persist($airplane);
            $this->addReference("A320-".$i, $airplane);
            $this->generateSeats(6, "A320-".$i, $this->getReference('businessClass'));
            $this->generateSeats(12, "A320-" . $i, $this->getReference('relaxClass'));
            $this->generateSeats(36, "A320-".$i, $this->getReference('economyClass'));
            $this->actualSeat = 0;
        }
        $this->em->flush();
        $this->em->clear();

        /* Airbus A380 */
        $airTypeA380 = new AirplaneType();
        $airTypeA380->setName("380");
        $airTypeA380->setManufacturer("Airbus");
        $airTypeA380->addGate($this->getReference('G1'));
        $airTypeA380->addGate($this->getReference('G2'));
        $airTypeA380->addGate($this->getReference('G5'));
        $manager->persist($airTypeA380);

        for ($i = 0; $i < 2; $i++) {
            $airplane = new Airplane();
            $airplane->setCrewNumber(rand(2, 7));
            $airplane->setDateOfProduction(new \DateTime('last day of last month'));
            $airplane->setDateOfRevision(new \DateTime());
            $airplane->setAirplaneType($airTypeA380);
            $manager->persist($airplane);
            $this->addReference("A380-".$i, $airplane);
            $this->generateSeats(6, "A380-".$i, $this->getReference('millionaireClass'));
            $this->generateSeats(12, "A380-".$i, $this->getReference('businessClass'));
            $this->generateSeats(24, "A380-" . $i, $this->getReference('relaxClass'));
            $this->generateSeats(48, "A380-".$i, $this->getReference('economyClass'));
            $this->actualSeat = 0;
        }
        $this->em->flush();
        $this->em->clear();
    }

    public function getDependencies()
    {
        return array(
            GateFixture::class,
            AirplaneClassFixture::class
        );
    }
}
