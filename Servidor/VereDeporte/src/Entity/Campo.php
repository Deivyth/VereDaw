<?php

namespace App\Entity;

use App\Repository\CampoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CampoRepository::class)
 */
class Campo
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
    private $tipo;

    /**
     * @ORM\OneToOne(targetEntity=Reserva::class, mappedBy="id_campo", cascade={"persist", "remove"})
     */
    private $reserva;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getReserva(): ?Reserva
    {
        return $this->reserva;
    }

    public function setReserva(?Reserva $reserva): self
    {
        // unset the owning side of the relation if necessary
        if ($reserva === null && $this->reserva !== null) {
            $this->reserva->setIdCampo(null);
        }

        // set the owning side of the relation if necessary
        if ($reserva !== null && $reserva->getIdCampo() !== $this) {
            $reserva->setIdCampo($this);
        }

        $this->reserva = $reserva;

        return $this;
    }
}
