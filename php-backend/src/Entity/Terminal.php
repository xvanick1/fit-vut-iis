<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TerminalRepository")
 * @UniqueEntity("name")
 */
class Terminal
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
     * @ORM\OneToMany(targetEntity="App\Entity\Gate", mappedBy="terminal", orphanRemoval=true, cascade={"persist"})
     */
    private $gates;

    public function __construct()
    {
        $this->gates = new ArrayCollection();
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
            $gate->setTerminal($this);
        }

        return $this;
    }

    public function removeGate(Gate $gate): self
    {
        if ($this->gates->contains($gate)) {
            $this->gates->removeElement($gate);
            // set the owning side to null (unless already changed)
            if ($gate->getTerminal() === $this) {
                $gate->setTerminal(null);
            }
        }

        return $this;
    }

}
