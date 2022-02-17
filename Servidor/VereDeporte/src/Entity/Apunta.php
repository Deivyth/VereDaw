<?php

namespace App\Entity;

use App\Repository\ApuntaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ApuntaRepository::class)
 */
class Apunta
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Equipo::class, cascade={"persist", "remove"})
     */
    private $equipo;

    /**
     * @ORM\OneToOne(targetEntity=Liga::class, cascade={"persist", "remove"})
     */
    private $liga;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipo(): ?Equipo
    {
        return $this->equipo;
    }

    public function setEquipo(?Equipo $equipo): self
    {
        $this->equipo = $equipo;

        return $this;
    }

    public function getLiga(): ?Liga
    {
        return $this->liga;
    }

    public function setLiga(?Liga $liga): self
    {
        $this->liga = $liga;

        return $this;
    }
}
