<?php

namespace Application\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "permissions")]
class Permission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $label = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $identifier = null;

    #[ORM\ManyToOne(targetEntity: Permission::class, inversedBy: "children")]
    #[ORM\JoinColumn(name: "parent", referencedColumnName: "id")]
    protected Permission $parent;

    #[ORM\OneToMany(targetEntity: Permission::class, mappedBy: "parent")]
    private Collection $children;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(?string $identifier): static
    {
        $this->identifier = $identifier;
        return $this;
    }

    public function getParent(): Permission
    {
        return $this->parent;
    }

    public function setParent(Permission $parent): static
    {
        $this->parent = $parent;
        return $this;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Permission $child): static
    {
        $this->children[] = $child;
        $child->setParent($this);
        return $this;
    }
}
