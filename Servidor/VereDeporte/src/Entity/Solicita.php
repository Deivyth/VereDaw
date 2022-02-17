<?php

namespace App\Entity;

use App\Repository\SolicitaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SolicitaRepository::class)
 */
class Solicita
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Usuario::class, cascade={"persist", "remove"})
     */
    private $usuario;

    /**
     * @ORM\OneToOne(targetEntity=Equipo::class, cascade={"persist", "remove"})
     */
    private $equipo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
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
}
