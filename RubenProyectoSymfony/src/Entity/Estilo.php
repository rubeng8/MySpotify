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

    #[ORM\ManyToOne(inversedBy: 'estiloMusicalPreferido')]
    private ?Perfil $perfil = null;

    /**
     * @var Collection<int, Cancion>
     */
    #[ORM\ManyToMany(targetEntity: Cancion::class, inversedBy: 'generos')]
    #[ORM\JoinTable(name: 'estilo_cancion')] // Nombre de la tabla intermedia
    private Collection $cancions;

    public function __construct()
    {
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

    public function getPerfil(): ?Perfil
    {
        return $this->perfil;
    }

    public function setPerfil(?Perfil $perfil)
    {
        $this->perfil = $perfil;

        return $this;
    }

    /**
     * @return Collection<int, Cancion>
     */
    public function getCancions(): Collection
    {
        return $this->cancions;
    }

    public function addCancion(Cancion $cancion)
    {
        if (!$this->cancions->contains($cancion)) {
            $this->cancions->add($cancion);
            // Para una relación ManyToMany, no es necesario modificar la propiedad de la otra parte aquí
            $cancion->addEstilo($this);  // Agregar este estilo a la canción (si es necesario)
        }

        return $this;
    }

    public function removeCancion(Cancion $cancion)
    {
        if ($this->cancions->removeElement($cancion)) {
            // Para una relación ManyToMany, no es necesario modificar la propiedad de la otra parte aquí
            $cancion->removeEstilo($this);  // Eliminar este estilo de la canción (si es necesario)
        }

        return $this;
    }
}
