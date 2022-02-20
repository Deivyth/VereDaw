<?php

namespace App\Entity;

use App\Repository\LigaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LigaRepository::class)
 */
class Liga
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fecha_inicio;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $fecha_fin;

    /**
     * @ORM\ManyToMany(targetEntity=Equipo::class, inversedBy="ligas")
     */
    private $apunta;

    /**
     * @ORM\OneToMany(targetEntity=Partido::class, mappedBy="liga")
     */
    private $partidos;

    public function __construct()
    {
        $this->apunta = new ArrayCollection();
        $this->partidos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(\DateTimeInterface $fecha_inicio): self
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(?\DateTimeInterface $fecha_fin): self
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }

    /**
     * @return Collection|Equipo[]
     */
    public function getApunta(): Collection
    {
        return $this->apunta;
    }

    public function addApuntum(Equipo $apuntum): self
    {
        if (!$this->apunta->contains($apuntum)) {
            $this->apunta[] = $apuntum;
        }

        return $this;
    }

    public function removeApuntum(Equipo $apuntum): self
    {
        $this->apunta->removeElement($apuntum);

        return $this;
    }

    /**
     * @return Collection|Partido[]
     */
    public function getPartidos(): Collection
    {
        return $this->partidos;
    }

    public function addPartido(Partido $partido): self
    {
        if (!$this->partidos->contains($partido)) {
            $this->partidos[] = $partido;
            $partido->setLiga($this);
        }

        return $this;
    }

    public function removePartido(Partido $partido): self
    {
        if ($this->partidos->removeElement($partido)) {
            // set the owning side to null (unless already changed)
            if ($partido->getLiga() === $this) {
                $partido->setLiga(null);
            }
        }

        return $this;
    }

}
