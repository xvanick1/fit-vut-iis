<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $dateOfDeparture;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank()
     * @Assert\Time()
     */
    private $timeOfDeparture;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank()
     * @Assert\Time()
     */
    private $flightLength;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airplane")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $airplane;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Gate", inversedBy="flights")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull()
     */
    private $gate;


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

    public function getFlightLength(): ?\DateTimeInterface
    {
        return $this->flightLength;
    }

    public function setFlightLength(\DateTimeInterface $flightLength): self
    {
        $this->flightLength = $flightLength;

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

    public function getAirplane(): ?Airplane
    {
        return $this->airplane;
    }

    public function setAirplane(?Airplane $airplane): self
    {
        $this->airplane = $airplane;

        return $this;
    }

    public function getGate(): ?Gate
    {
        return $this->gate;
    }

    public function setGate(?Gate $gate): self
    {
        $this->gate = $gate;

        return $this;
    }

}
