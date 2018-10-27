<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlightTicketRepository")
 */
class FlightTicket
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $surname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Flight")
     * @ORM\JoinColumn(nullable=false)
     */
    private $flightID;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AirplaneClass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $airplaneClassID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getFlightID(): ?Flight
    {
        return $this->flightID;
    }

    public function setFlightID(?Flight $flightID): self
    {
        $this->flightID = $flightID;

        return $this;
    }

    public function getAirplaneClassID(): ?AirplaneClass
    {
        return $this->airplaneClassID;
    }

    public function setAirplaneClassID(?AirplaneClass $airplaneClassID): self
    {
        $this->airplaneClassID = $airplaneClassID;

        return $this;
    }
}
