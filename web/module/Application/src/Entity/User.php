<?php

namespace Application\Entity;

use Application\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Laminas\Crypt\Password\Bcrypt;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["user", "manager"])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(["user", "manager"])]
    private ?string $email = null;

    #[ORM\ManyToOne(targetEntity:Role::class)]
    #[ORM\JoinColumn(nullable:false)]
    private Role $role;

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(["user", "manager"])]
    private ?string $password = null;

    private string $plainPassword;

    #[ORM\Column(length: 255)]
    #[Groups(["user", "manager"])]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    #[Groups(["user", "manager"])]
    private ?string $last_name = null;

    #[ORM\Column]
    #[Groups(["user", "manager"])]
    private ?bool $inactive = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getRole(): Role
    {
        return $this->role;
    }

    public function setRole(Role $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getPlainPassword(): string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): static
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): static
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function isInactive(): ?bool
    {
        return $this->inactive;
    }

    public function setInactive(bool $inactive): static
    {
        $this->inactive = $inactive;

        return $this;
    }

    public static function verifyHashedPassword(User $user, $passwordGiven): bool
    {
        $bcrypt = new Bcrypt([
            'cost' => 10
        ]);
        return $bcrypt->verify($passwordGiven, $user->getPassword());
    }
}
