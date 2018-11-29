<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\GreaterThan(value="0")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    private $seatNumber;

    /**
     * @ORM\Column(type="string", length=6)
     * @Assert\NotBlank()
     * @Assert\Length(min="1", max="6")
     * @Assert\Type(type="string")
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airplane", inversedBy="seats")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $airplane;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AirplaneClass", inversedBy="seats")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $airplaneClass;

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

    public function getAirplane(): ?Airplane
    {
        return $this->airplane;
    }

    public function setAirplane(?Airplane $airplane): self
    {
        $this->airplane = $airplane;

        return $this;
    }

    public function getAirplaneClass(): ?AirplaneClass
    {
        return $this->airplaneClass;
    }

    public function setAirplaneClass(?AirplaneClass $airplaneClass): self
    {
        $this->airplaneClass = $airplaneClass;

        return $this;
    }
}
