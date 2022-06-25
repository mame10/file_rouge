<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource]
class Burger extends Produit
{
    #[ORM\ManyToOne(targetEntity: Catologues::class, inversedBy: 'burgers')]
    private $catologues;

    #[ORM\ManyToMany(targetEntity: Menu::class, inversedBy: 'burgers')]
    private $menus;

    public function __construct()
    {
        $this->menus = new ArrayCollection();
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
     * @return Collection<int, Menu>
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        $this->menus->removeElement($menu);

        return $this;
    }
}
