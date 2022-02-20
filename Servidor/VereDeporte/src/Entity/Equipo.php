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
     * @ORM\ManyToMany(targetEntity=Usuario::class, mappedBy="solicitud")
     */
    private $usuarios;

    /**
     * @ORM\OneToMany(targetEntity=Reserva::class, mappedBy="equipo")
     */
    private $reservas;

    /**
     * @ORM\ManyToMany(targetEntity=Liga::class, mappedBy="apunta")
     */
    private $ligas;

    public function __construct()
    {
        $this->usuarios = new ArrayCollection();
        $this->reservas = new ArrayCollection();
        $this->partidos = new ArrayCollection();
        $this->ligas = new ArrayCollection();
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
        //base64_encode(stream_get_contents($this->photo,-1,-1))
        return $this->photo;;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|Usuario[]
     */
    public function getUsuarios(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuario $usuario): self
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios[] = $usuario;
            $usuario->addSolicitud($this);
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario): self
    {
        if ($this->usuarios->removeElement($usuario)) {
            $usuario->removeSolicitud($this);
        }

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
            $reserva->setEquipo($this);
        }

        return $this;
    }

    public function removeReserva(Reserva $reserva): self
    {
        if ($this->reservas->removeElement($reserva)) {
            // set the owning side to null (unless already changed)
            if ($reserva->getEquipo() === $this) {
                $reserva->setEquipo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Liga[]
     */
    public function getLigas(): Collection
    {
        return $this->ligas;
    }

    public function addLiga(Liga $liga): self
    {
        if (!$this->ligas->contains($liga)) {
            $this->ligas[] = $liga;
            $liga->addApuntum($this);
        }

        return $this;
    }

    public function removeLiga(Liga $liga): self
    {
        if ($this->ligas->removeElement($liga)) {
            $liga->removeApuntum($this);
        }

        return $this;
    }

}
