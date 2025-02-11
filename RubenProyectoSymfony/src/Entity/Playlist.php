<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: 'boolean')]
    private ?bool $visibilidad = null;

    #[ORM\Column]
    private ?int $reproducciones = null;

    #[ORM\Column]
    private ?int $likes = null;

    #[ORM\ManyToOne(inversedBy: 'playlists')]
    private ?Usuario $propietario = null;

    /**
     * @var Collection<int, UsuarioPlaylist>
     */
    #[ORM\OneToMany(targetEntity: UsuarioPlaylist::class, mappedBy: 'playlist', cascade: ['persist'])]
    private Collection $usuarioPlaylists;

    /**
     * @var Collection<int, PlaylistCancion>
     */
    #[ORM\OneToMany(targetEntity: PlaylistCancion::class, mappedBy: 'playlist', cascade: ['persist', 'remove'])]
    private Collection $playlistCancions;

    public function __construct()
    {
        $this->usuarioPlaylists = new ArrayCollection();
        $this->playlistCancions = new ArrayCollection();
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

    public function getVisibilidad(): ?string
    {
        return $this->visibilidad;
    }

    public function setVisibilidad(string $visibilidad)
    {
        $this->visibilidad = $visibilidad;

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

    public function getPropietario(): ?Usuario
    {
        return $this->propietario;
    }

    public function setPropietario(?Usuario $propietario)
    {
        $this->propietario = $propietario;

        return $this;
    }

    /**
     * @return Collection<int, UsuarioPlaylist>
     */
    public function getUsuarioPlaylists(): Collection
    {
        return $this->usuarioPlaylists;
    }

    public function addUsuarioPlaylist(UsuarioPlaylist $usuarioPlaylist)
    {
        if (!$this->usuarioPlaylists->contains($usuarioPlaylist)) {
            $this->usuarioPlaylists->add($usuarioPlaylist);
            $usuarioPlaylist->setPlaylist($this);
        }

        return $this;
    }

    public function removeUsuarioPlaylist(UsuarioPlaylist $usuarioPlaylist)
    {
        if ($this->usuarioPlaylists->removeElement($usuarioPlaylist)) {
            // set the owning side to null (unless already changed)
            if ($usuarioPlaylist->getPlaylist() === $this) {
                $usuarioPlaylist->setPlaylist(null);
            }
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
            $playlistCancion->setPlaylist($this);
        }

        return $this;
    }

    public function removePlaylistCancion(PlaylistCancion $playlistCancion)
    {
        if ($this->playlistCancions->removeElement($playlistCancion)) {
            // set the owning side to null (unless already changed)
            if ($playlistCancion->getPlaylist() === $this) {
                $playlistCancion->setPlaylist(null);
            }
        }

        return $this;
    }
}
