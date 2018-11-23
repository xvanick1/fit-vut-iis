<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GateRepository")
 */
class Gate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Terminal", inversedBy="gates")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $terminal;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\AirplaneType", cascade={"remove"})
     */
    private $airplaneTypes;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="gate", orphanRemoval=true)
     */
    private $flights;


    public function __construct()
    {
        $this->airplaneTypes = new ArrayCollection();
        $this->flights = new ArrayCollection();
    }

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

    public function getTerminal(): ?terminal
    {
        return $this->terminal;
    }

    public function setTerminal(?terminal $terminal): self
    {
        $this->terminal = $terminal;

        return $this;
    }

    /**
     * @return Collection|AirplaneType[]
     */
    public function getAirplaneTypes(): Collection
    {
        return $this->airplaneTypes;
    }

    public function addAirplaneType(AirplaneType $airplaneType): self
    {
        if (!$this->airplaneTypes->contains($airplaneType)) {
            $this->airplaneTypes[] = $airplaneType;
        }

        return $this;
    }

    public function removeAirplaneType(AirplaneType $airplaneType): self
    {
        if ($this->airplaneTypes->contains($airplaneType)) {
            $this->airplaneTypes->removeElement($airplaneType);
        }

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
            $flight->setGate($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            // set the owning side to null (unless already changed)
            if ($flight->getGate() === $this) {
                $flight->setGate(null);
            }
        }

        return $this;
    }

}
