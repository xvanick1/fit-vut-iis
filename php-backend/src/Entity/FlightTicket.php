<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlightTicketRepository")
 * @UniqueEntity("boardingPass")
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
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $surname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Flight")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $flight;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AirplaneClass")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $airplaneClass;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\BoardingPass", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false, unique=true)
     */
    private $boardingPass;

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

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

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

    public function getBoardingPass(): ?BoardingPass
    {
        return $this->boardingPass;
    }

    public function setBoardingPass(BoardingPass $boardingPass): self
    {
        $this->boardingPass = $boardingPass;

        return $this;
    }

}
