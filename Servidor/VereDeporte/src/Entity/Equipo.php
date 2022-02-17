<?php

namespace App\Entity;

use App\Repository\EquipoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipoRepository::class)
 */
class Equipo
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
     * @ORM\OneToOne(targetEntity=Usuario::class, inversedBy="equipo", cascade={"persist", "remove"})
     */
    private $capitan;

    /**
     * @ORM\Column(type="blob")
     */
    private $photo;

    /**
     * @ORM\OneToMany(targetEntity=Reserva::class, mappedBy="id_equipo")
     */
    private $reservas;

    /**
     * @ORM\OneToMany(targetEntity=Partido::class, mappedBy="id_local")
     */
    private $partidos;

    public function __construct()
    {
        $this->solicitas = new ArrayCollection();
        $this->reservas = new ArrayCollection();
        $this->apuntas = new ArrayCollection();
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

    public function getCapitan(): ?Usuario
    {
        return $this->capitan;
    }

    public function setCapitan(?Usuario $capitan): self
    {
        $this->capitan = $capitan;

        return $this;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|Reserva[]
     */
    public function getReservas(): Collection
    {
        return $this->reservas;
    }

    public function addReserva(Reserva $reserva): self
    {
        if (!$this->reservas->contains($reserva)) {
            $this->reservas[] = $reserva;
            $reserva->setIdEquipo($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): self
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getIdEquipo() === $this) {
                $reserva->setIdEquipo(null);
            }
        }

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
            $partido->setIdLocal($this);
        }

        return $this;
    }

    public function removePartido(Partido $partido): self
    {
        if ($this->partidos->removeElement($partido)) {
            // set the owning side to null (unless already changed)
            if ($partido->getIdLocal() === $this) {
                $partido->setIdLocal(null);
            }
        }

        return $this;
    }
}
