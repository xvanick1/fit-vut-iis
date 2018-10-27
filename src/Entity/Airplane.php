<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $crewNumber;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfProduction;

    /**
     * @ORM\Column(type="date")
     */
    private $dateOfRevision;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AirplaneType")
     * @ORM\JoinColumn(nullable=false)
     */
    private $airplaneType;

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
}
