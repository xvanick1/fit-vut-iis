<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

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
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\terminal")
     * @ORM\JoinColumn(nullable=false)
     */
    private $terminal;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\AirplaneType")
     */
    private $airplaneTypes;

    public function __construct()
    {
        $this->airplaneTypes = new ArrayCollection();
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
}
