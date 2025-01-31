<?php

namespace App\Entity;

use App\Repository\EstiloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EstiloRepository::class)]
class Estilo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\ManyToMany(targetEntity: Perfil::class, mappedBy: 'estiloMusicalPreferido')]
    private Collection $perfiles;

    #[ORM\OneToMany(targetEntity: Cancion::class, mappedBy: 'genero', cascade: ['persist'])]
    private Collection $cancions;

    public function __construct()
    {
        $this->perfiles = new ArrayCollection();
        $this->cancions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getPerfiles(): Collection
    {
        return $this->perfiles;
    }

    public function addPerfil(Perfil $perfil)
    {
        if (!$this->perfiles->contains($perfil)) {
            $this->perfiles->add($perfil);
        }

        return $this;
    }

    public function removePerfil(Perfil $perfil)
    {
        $this->perfiles->removeElement($perfil);

        return $this;
    }

    public function getCancions(): Collection
    {
        return $this->cancions;
    }

    public function addCancion(Cancion $cancion)
    {
        if (!$this->cancions->contains($cancion)) {
            $this->cancions->add($cancion);
        }

        return $this;
    }

    public function removeCancion(Cancion $cancion)
    {
        $this->cancions->removeElement($cancion);

        return $this;
    }

    public function __toString():string
    {
        return $this->nombre;
    }
}
