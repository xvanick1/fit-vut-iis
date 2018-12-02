<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BoardingPassRepository")
 */
class BoardingPass
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Seat")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $seat;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FlightTicket", mappedBy="boardingPass")
     * @ORM\JoinColumn(nullable=false, unique=true)
     * @Assert\NotBlank()
     */
    private $flightTicket;

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

    public function getSeat(): ?Seat
    {
        return $this->seat;
    }

    public function setSeat(?Seat $seat): self
    {
        $this->seat = $seat;

        return $this;
    }

    public function getFlightTicket(): ?FlightTicket
    {
        return $this->flightTicket;
    }

    public function setFlightTicket(?FlightTicket $flightTicket): self
    {
        $this->flightTicket = $flightTicket;

        // set (or unset) the owning side of the relation if necessary
        $newBoardingPass = $flightTicket === null ? null : $this;
        if ($newBoardingPass !== $flightTicket->getBoardingPass()) {
            $flightTicket->setBoardingPass($newBoardingPass);
        }

        return $this;
    }
}
