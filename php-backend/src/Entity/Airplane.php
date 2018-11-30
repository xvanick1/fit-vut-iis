<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AirplaneRepository")
 */
class Airplane
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    private $crewNumber;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $dateOfProduction;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     * @Assert\GreaterThanOrEqual(propertyPath="dateOfProduction")
     */
    private $dateOfRevision;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AirplaneType", inversedBy="airplanes")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $airplaneType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="airplane")
     */
    private $flights;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Seat", mappedBy="airplane", orphanRemoval=true)
     */
    private $seats;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
        $this->seats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCrewNumber(): ?int
    {
        return $this->crewNumber;
    }

    public function setCrewNumber(int $crewNumber): self
    {
        $this->crewNumber = $crewNumber;

        return $this;
    }

    public function getDateOfProduction(): ?\DateTimeInterface
    {
        return $this->dateOfProduction;
    }

    public function setDateOfProduction(\DateTimeInterface $dateOfProduction): self
    {
        $this->dateOfProduction = $dateOfProduction;

        return $this;
    }

    public function getDateOfRevision(): ?\DateTimeInterface
    {
        return $this->dateOfRevision;
    }

    public function setDateOfRevision(\DateTimeInterface $dateOfRevision): self
    {
        $this->dateOfRevision = $dateOfRevision;

        return $this;
    }

    public function getAirplaneType(): ?AirplaneType
    {
        return $this->airplaneType;
    }

    public function setAirplaneType(?AirplaneType $airplaneType): self
    {
        $this->airplaneType = $airplaneType;

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): self
    {
        if (!$this->flights->contains($flight)) {
            $this->flights[] = $flight;
            $flight->setAirplane($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            // set the owning side to null (unless already changed)
            if ($flight->getAirplane() === $this) {
                $flight->setAirplane(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Seat[]
     */
    public function getSeats(): Collection
    {
        return $this->seats;
    }

    public function addSeat(Seat $seat): self
    {
        if (!$this->seats->contains($seat)) {
            $this->seats[] = $seat;
            $seat->setAirplane($this);
        }

        return $this;
    }

    public function removeSeat(Seat $seat): self
    {
        if ($this->seats->contains($seat)) {
            $this->seats->removeElement($seat);
            // set the owning side to null (unless already changed)
            if ($seat->getAirplane() === $this) {
                $seat->setAirplane(null);
            }
        }

        return $this;
    }
}
