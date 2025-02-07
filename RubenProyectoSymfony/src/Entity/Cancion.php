<?php

namespace App\Entity;

use App\Repository\CancionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CancionRepository::class)]
class Cancion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titulo = null;

    #[ORM\Column]
    private ?int $duracion = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $album = null;

    #[ORM\Column(length: 255)]
    private ?string $autor = null;

    #[ORM\Column]
    private ?int $reproducciones = null;

    #[ORM\Column]
    private ?int $likes = null;

    /**
     * @var Estilo
     */
    #[ORM\ManyToOne(targetEntity: Estilo::class, inversedBy: 'cancions', cascade:['persist'])]
    private ?Estilo $genero = null; // Aquí se cambió de Collection a Estilo

    /**
     * @var Collection<int, PlaylistCancion>
     */
    #[ORM\OneToMany(targetEntity: PlaylistCancion::class, mappedBy: 'cancion', cascade:['persist'])]
    private Collection $playlistCancions;

    /**
     * @var Collection<int, Usuario>
     */
    #[ORM\ManyToMany(targetEntity: Usuario::class, inversedBy: 'canciones', cascade:['persist'])]
    private Collection $usuarios;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $portada = null;

    #[ORM\Column(length: 255)]
    private ?string $archivo = null;

    public function __construct()
    {
        $this->playlistCancions = new ArrayCollection();
        $this->usuarios = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->titulo;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(int $duracion)
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getAlbum(): ?string
    {
        return $this->album;
    }

    public function setAlbum(?string $album)
    {
        $this->album = $album;

        return $this;
    }

    public function getAutor(): ?string
    {
        return $this->autor;
    }

    public function setAutor(string $autor)
    {
        $this->autor = $autor;

        return $this;
    }

    public function getReproducciones(): ?int
    {
        return $this->reproducciones;
    }

    public function setReproducciones(int $reproducciones)
    {
        $this->reproducciones = $reproducciones;

        return $this;
    }

    public function getLikes(): ?int
    {
        return $this->likes;
    }

    public function setLikes(int $likes)
    {
        $this->likes = $likes;

        return $this;
    }

    public function getGenero(): ?Estilo
    {
        return $this->genero;
    }

    public function setGenero(?Estilo $genero): self
    {
        if ($genero !== null) {
            $this->genero = $genero;
        }

        return $this;
    }

    /**
     * @return Collection<int, PlaylistCancion>
     */
    public function getPlaylistCancions(): Collection
    {
        return $this->playlistCancions;
    }

    public function addPlaylistCancion(PlaylistCancion $playlistCancion)
    {
        if (!$this->playlistCancions->contains($playlistCancion)) {
            $this->playlistCancions->add($playlistCancion);
            $playlistCancion->setCancion($this);
        }

        return $this;
    }

    public function removePlaylistCancion(PlaylistCancion $playlistCancion)
    {
        if ($this->playlistCancions->removeElement($playlistCancion)) {

            if ($playlistCancion->getCancion() === $this) {
                $playlistCancion->setCancion(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Usuario>
     */
    public function getUsuario(): Collection
    {
        return $this->usuarios;
    }

    public function addUsuario(Usuario $usuario)
    {
        if (!$this->usuarios->contains($usuario)) {
            $this->usuarios->add($usuario);
        }

        return $this;
    }

    public function removeUsuario(Usuario $usuario)
    {
        $this->usuarios->removeElement($usuario);

        return $this;
    }

    public function getPortada(): ?string
    {
        return $this->portada;
    }

    public function setPortada(?string $portada): static
    {
        $this->portada = $portada;

        return $this;
    }

    public function getArchivo(): ?string
    {
        return $this->archivo;
    }

    public function setArchivo(string $archivo): static
    {
        $this->archivo = $archivo;

        return $this;
    }
}
