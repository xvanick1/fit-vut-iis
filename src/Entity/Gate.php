<?php

namespace App\Entity;

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
}
