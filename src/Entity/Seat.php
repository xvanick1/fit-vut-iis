<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SeatRepository")
 */
class Seat
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $seatNumber;

    /**
     * @ORM\Column(type="string", length=6)
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airplane")
     */
    private $airplaneID;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AirplaneClass")
     * @ORM\JoinColumn(nullable=false)
     */
    private $airplaneClassID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeatNumber(): ?int
    {
        return $this->seatNumber;
    }

    public function setSeatNumber(int $seatNumber): self
    {
        $this->seatNumber = $seatNumber;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

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
