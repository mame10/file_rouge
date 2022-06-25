<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource]
class Menu extends Produit
{
    #[ORM\ManyToOne(targetEntity: Catologues::class, inversedBy: 'menus')]
    private $catologues;

    #[ORM\ManyToMany(targetEntity: Burger::class, mappedBy: 'menus')]
    private $burgers;

    #[ORM\ManyToMany(targetEntity: Taille::class, inversedBy: 'menus')]
    private $boissons;


    public function __construct()
    {
        $this->burgers = new ArrayCollection();
        $this->boissons = new ArrayCollection();
    }

    public function getCatologues(): ?Catologues
    {
        return $this->catologues;
    }

    public function setCatologues(?Catologues $catologues): self
    {
        $this->catologues = $catologues;

        return $this;
    }

    /**
     * @return Collection<int, Burger>
     */
    public function getBurgers(): Collection
    {
        return $this->burgers;
    }

    public function addBurger(Burger $burger): self
    {
        if (!$this->burgers->contains($burger)) {
            $this->burgers[] = $burger;
            $burger->addMenu($this);
        }

        return $this;
    }

    public function removeBurger(Burger $burger): self
    {
        if ($this->burgers->removeElement($burger)) {
            $burger->removeMenu($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Taille $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
        }

        return $this;
    }

    public function removeBoisson(Taille $boisson): self
    {
        $this->boissons->removeElement($boisson);

        return $this;
    }

   
}
