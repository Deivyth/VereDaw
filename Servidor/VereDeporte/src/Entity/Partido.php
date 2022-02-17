<?php

namespace App\Entity;

use App\Repository\PartidoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PartidoRepository::class)
 */
class Partido
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Equipo::class, inversedBy="partidos")
     */
    private $id_local;

    /**
     * @ORM\ManyToOne(targetEntity=Equipo::class, inversedBy="partidos")
     */
    private $id_visitante;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="partidos")
     */
    private $id_usuario;

    /**
     * @ORM\OneToOne(targetEntity=Campo::class, cascade={"persist", "remove"})
     */
    private $id_campo;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resultado;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdLocal(): ?Equipo
    {
        return $this->id_local;
    }

    public function setIdLocal(?Equipo $id_local): self
    {
        $this->id_local = $id_local;

        return $this;
    }

    public function getIdVisitante(): ?Equipo
    {
        return $this->id_visitante;
    }

    public function setIdVisitante(?Equipo $id_visitante): self
    {
        $this->id_visitante = $id_visitante;

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

    public function getResultado(): ?string
    {
        return $this->resultado;
    }

    public function setResultado(string $resultado): self
    {
        $this->resultado = $resultado;

        return $this;
    }
}
