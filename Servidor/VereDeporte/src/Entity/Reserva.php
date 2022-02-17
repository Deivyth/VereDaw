<?php

namespace App\Entity;

use App\Repository\ReservaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ReservaRepository::class)
 */
class Reserva
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Equipo::class, inversedBy="reservas")
     */
    private $id_equipo;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="reservas")
     */
    private $id_usuario;

    /**
     * @ORM\OneToOne(targetEntity=Campo::class, inversedBy="reserva", cascade={"persist", "remove"})
     */
    private $id_campo;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEquipo(): ?Equipo
    {
        return $this->id_equipo;
    }

    public function setIdEquipo(?Equipo $id_equipo): self
    {
        $this->id_equipo = $id_equipo;

        return $this;
    }

    public function getIdUsuario(): ?Usuario
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?Usuario $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }

    public function getIdCampo(): ?Campo
    {
        return $this->id_campo;
    }

    public function setIdCampo(?Campo $id_campo): self
    {
        $this->id_campo = $id_campo;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }
}
