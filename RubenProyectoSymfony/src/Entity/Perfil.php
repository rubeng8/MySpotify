<?php

namespace App\Entity;

use App\Repository\PerfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PerfilRepository::class)]
class Perfil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto = null;

    #[ORM\Column(length: 255)]
    private ?string $descripcion = null;

    #[ORM\ManyToMany(targetEntity: Estilo::class, inversedBy: 'perfiles', cascade: ['persist'])]
    private Collection $estiloMusicalPreferido;

    #[ORM\OneToOne(mappedBy: 'perfil', cascade: ['persist', 'remove'])]
    private ?Usuario $usuario = null;

    public function __construct()
    {
        $this->estiloMusicalPreferido = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto)
    {
        $this->foto = $foto;

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

    public function getEstiloMusicalPreferido(): Collection
    {
        return $this->estiloMusicalPreferido;
    }

    public function addEstiloMusicalPreferido(Estilo $estiloMusicalPreferido)
    {
        if (!$this->estiloMusicalPreferido->contains($estiloMusicalPreferido)) {
            $this->estiloMusicalPreferido->add($estiloMusicalPreferido);
        }

        return $this;
    }

    public function removeEstiloMusicalPreferido(Estilo $estiloMusicalPreferido)
    {
        $this->estiloMusicalPreferido->removeElement($estiloMusicalPreferido);

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(Usuario $usuario)
    {
        if ($usuario->getPerfil() !== $this) {
            $usuario->setPerfil($this);
        }

        $this->usuario = $usuario;

        return $this;
    }
}
