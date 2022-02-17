<?php

namespace App\Entity;

use App\Repository\PeliculasRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PeliculasRepository::class)
 */
class Peliculas
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
    private $titulo;

    /**
     * @ORM\Column(type="integer")
     */
    private $anyo;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): self
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getAnyo(): ?int
    {
        return $this->anyo;
    }

    public function setAnyo(int $anyo): self
    {
        $this->anyo = $anyo;

        return $this;
    }
}
