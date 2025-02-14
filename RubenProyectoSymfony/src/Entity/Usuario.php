<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: UsuarioRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Este email ya está en uso.')]
class Usuario implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;


    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fechaNacimiento = null;

    #[ORM\OneToOne(inversedBy: 'usuario', cascade: ['persist', 'remove'])]
    private ?Perfil $perfil = null;

    /**
     * @var Collection<int, Playlist>
     */
    #[ORM\OneToMany(targetEntity: Playlist::class, mappedBy: 'propietario')]
    private Collection $playlists;

    /**
     * @var Collection<int, UsuarioPlaylist>
     */
    #[ORM\OneToMany(targetEntity: UsuarioPlaylist::class, mappedBy: 'usuario')]
    private Collection $usuarioPlaylists;

    /**
     * @var Collection<int, Cancion>
     */
    #[ORM\ManyToMany(targetEntity: Cancion::class, inversedBy: 'usuarios')]
    private Collection $cancion;

    public function __construct()
    {
        $this->playlists = new ArrayCollection();
        $this->usuarioPlaylists = new ArrayCollection();
        $this->cancion = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->nombre;
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

     /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

     /**
     * @see UserInterface
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;


        return array_unique($roles);
    }

     /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

     /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fechaNacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

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
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist)
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->setPropietario($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist)
    {
        if ($this->playlists->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getPropietario() === $this) {
                $playlist->setPropietario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UsuarioPlaylist>
     */
    public function getUsuarioPlaylists(): Collection
    {
        return $this->usuarioPlaylists;
    }

    public function addUsuarioPlaylist(UsuarioPlaylist $usuarioPlaylist): static
    {
        if (!$this->usuarioPlaylists->contains($usuarioPlaylist)) {
            $this->usuarioPlaylists->add($usuarioPlaylist);
            $usuarioPlaylist->setUsuario($this);
        }

        return $this;
    }

    public function removeUsuarioPlaylist(UsuarioPlaylist $usuarioPlaylist): static
    {
        if ($this->usuarioPlaylists->removeElement($usuarioPlaylist)) {
            // set the owning side to null (unless already changed)
            if ($usuarioPlaylist->getUsuario() === $this) {
                $usuarioPlaylist->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Cancion>
     */
    public function getCancion(): Collection
    {
        return $this->cancion;
    }

    public function addCancion(Cancion $cancion): static
    {
        if (!$this->cancion->contains($cancion)) {
            $this->cancion->add($cancion);
        }

        return $this;
    }

    public function removeCancion(Cancion $cancion): static
    {
        $this->cancion->removeElement($cancion);

        return $this;
    }
}
