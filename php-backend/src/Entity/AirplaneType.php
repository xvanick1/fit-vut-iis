<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AirplaneTypeRepository")
 * @ORM\Table(
 *     uniqueConstraints={@ORM\UniqueConstraint(name="airplane_type_manufacturer", columns={"name", "manufacturer"})}
 * )
 */
class AirplaneType
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
    private $manufacturer;

    /**
     * @ORM\Column(type="string", length=200)
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Gate", inversedBy="airplaneTypes")
     */
    private $gates;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Airplane", mappedBy="airplaneType", orphanRemoval=true)
     */
    private $airplanes;

    public function __construct()
    {
        $this->gates = new ArrayCollection();
        $this->airplanes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getManufacturer(): ?string
    {
        return $this->manufacturer;
    }

    public function setManufacturer(string $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
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

    /**
     * @return Collection|Gate[]
     */
    public function getGates(): Collection
    {
        return $this->gates;
    }

    public function addGate(Gate $gate): self
    {
        if (!$this->gates->contains($gate)) {
            $this->gates[] = $gate;
        }

        return $this;
    }

    public function removeGate(Gate $gate): self
    {
        if ($this->gates->contains($gate)) {
            $this->gates->removeElement($gate);
        }

        return $this;
    }

    /**
     * @return Collection|Airplane[]
     */
    public function getAirplanes(): Collection
    {
        return $this->airplanes;
    }

}
