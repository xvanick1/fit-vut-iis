<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlightRepository")
 */
class Flight
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfDeparture;

    /**
     * @ORM\Column(type="time")
     */
    private $timeOfDeparture;

    /**
     * @ORM\Column(type="time")
     */
    private $fightLength;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airplane")
     * @ORM\JoinColumn(nullable=false)
     */
    private $airplaneID;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gate")
     */
    private $gateID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateOfDeparture(): ?\DateTimeInterface
    {
        return $this->dateOfDeparture;
    }

    public function setDateOfDeparture(\DateTimeInterface $dateOfDeparture): self
    {
        $this->dateOfDeparture = $dateOfDeparture;

        return $this;
    }

    public function getTimeOfDeparture(): ?\DateTimeInterface
    {
        return $this->timeOfDeparture;
    }

    public function setTimeOfDeparture(\DateTimeInterface $timeOfDeparture): self
    {
        $this->timeOfDeparture = $timeOfDeparture;

        return $this;
    }

    public function getFightLength(): ?\DateTimeInterface
    {
        return $this->fightLength;
    }

    public function setFightLength(\DateTimeInterface $fightLength): self
    {
        $this->fightLength = $fightLength;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getAirplaneID(): ?Airplane
    {
        return $this->airplaneID;
    }

    public function setAirplaneID(?Airplane $airplaneID): self
    {
        $this->airplaneID = $airplaneID;

        return $this;
    }

    public function getGateID(): ?Gate
    {
        return $this->gateID;
    }

    public function setGateID(?Gate $gateID): self
    {
        $this->gateID = $gateID;

        return $this;
    }
}
