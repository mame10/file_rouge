<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\Annotation\ApiResource;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource]
class PortionFrite extends Produit
{
    #[ORM\ManyToOne(targetEntity: Complements::class, inversedBy: 'portions')]
    private $complements;

    #[ORM\ManyToMany(targetEntity: Menu::class, mappedBy: 'portionsFrites')]
    private $menus;

    public function __construct()
    {
        parent::__construct();
        $this->menus = new ArrayCollection();
        
    }

    public function getComplements(): ?Complements
    {
        return $this->complements;
    }

    public function setComplements(?Complements $complements): self
    {
        $this->complements = $complements;

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
            $menu->addPortionsFrite($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->removeElement($menu)) {
            $menu->removePortionsFrite($this);
        }

        return $this;
    }

}
