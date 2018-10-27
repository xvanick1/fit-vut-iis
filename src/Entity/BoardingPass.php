<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=200)
     */
    private $surname;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Seat")
     * @ORM\JoinColumn(nullable=false)
     */
    private $seatID;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\FlightTicket", cascade={"persist", "remove"})
     */
    private $flightTicketID;

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

    public function getSeatID(): ?Seat
    {
        return $this->seatID;
    }

    public function setSeatID(?Seat $seatID): self
    {
        $this->seatID = $seatID;

        return $this;
    }

    public function getFlightTicketID(): ?FlightTicket
    {
        return $this->flightTicketID;
    }

    public function setFlightTicketID(?FlightTicket $flightTicketID): self
    {
        $this->flightTicketID = $flightTicketID;

        return $this;
    }
}
