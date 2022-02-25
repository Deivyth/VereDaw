<?php

namespace App\Entity;

use App\Repository\PartidoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
    private $local;

    /**
     * @ORM\ManyToOne(targetEntity=Equipo::class, inversedBy="partidos")
     */
    private $visitante;

    /**
     * @ORM\ManyToOne(targetEntity=Usuario::class, inversedBy="partidos")
     */
    private $vigilante;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fecha;

    /**
     * @ORM\ManyToOne(targetEntity=Liga::class, inversedBy="partidos")
     */
    private $liga;

    /**
     * @ORM\ManyToOne(targetEntity=Campo::class, inversedBy="partidos")
     */
    private $campo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $puntosLocal;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $puntosVisitante;


    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocal(): ?Equipo
    {
        return $this->local;
    }

    public function setLocal(?Equipo $local): self
    {
        $this->local = $local;

        return $this;
    }

    public function getVisitante(): ?Equipo
    {
        return $this->visitante;
    }

    public function setVisitante(?Equipo $visitante): self
    {
        $this->visitante = $visitante;

        return $this;
    }

    public function getVigilante(): ?Usuario
    {
        return $this->vigilante;
    }

    public function setVigilante(?Usuario $vigilante): self
    {
        $this->vigilante = $vigilante;

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

    public function getLiga(): ?Liga
    {
        return $this->liga;
    }

    public function setLiga(?Liga $liga): self
    {
        $this->liga = $liga;

        return $this;
    }

    public function getCampo(): ?Campo
    {
        return $this->campo;
    }

    public function setCampo(?Campo $campo): self
    {
        $this->campo = $campo;

        return $this;
    }

    public function getPuntosLocal(): ?string
    {
        return $this->puntosLocal;
    }

    public function setPuntosLocal(?string $puntosLocal): self
    {
        $this->puntosLocal = $puntosLocal;

        return $this;
    }

    public function getPuntosVisitante(): ?string
    {
        return $this->puntosVisitante;
    }

    public function setPuntosVisitante(?string $puntosVisitante): self
    {
        $this->puntosVisitante = $puntosVisitante;

        return $this;
    }

}
