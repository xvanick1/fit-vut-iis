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
    private $nazev;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\terminal")
     * @ORM\JoinColumn(nullable=false)
     */
    private $terminal;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNazev(): ?string
    {
        return $this->nazev;
    }

    public function setNazev(string $nazev): self
    {
        $this->nazev = $nazev;

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
