<?php

namespace App\Entity;

use App\Repository\PlaylistCancionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistCancionRepository::class)]
class PlaylistCancion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'playlistCancions', cascade:['persist'])]
    private ?Playlist $playlist = null;

    #[ORM\ManyToOne(inversedBy: 'playlistCancions', cascade:['persist'])]
    private ?Cancion $cancion = null;

    public function __toString():string
    {
        return $this->getCancion()->getTitulo();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlaylist(): ?Playlist
    {
        return $this->playlist;
    }

    public function setPlaylist(?Playlist $playlist)
    {
        $this->playlist = $playlist;

        return $this;
    }

    public function getCancion(): ?Cancion
    {
        return $this->cancion;
    }

    public function setCancion(?Cancion $cancion)
    {
        $this->cancion = $cancion;

        return $this;
    }
}
