<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuPortionRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuPortionRepository::class)]
#[ApiResource()]
class MenuPortion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["menu:write"])]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups(["menu:write",'details:read:all'])]
    private $quantitePortion;

    #[ORM\ManyToOne(inversedBy: 'menuPortions')]
    private ?Menu $menus = null;

    #[ORM\ManyToOne(inversedBy: 'menuPortions')]
    #[Groups(["menu:write",'details:read:all'])]
    private ?PortionFrite $portionFrites = null;

    // #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuPortions')]
    // private $menu;

    // #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'portionMenus')]
    // #[Groups(["menu:write"])]
    // private $portionFrite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantitePortion(): ?int
    {
        return $this->quantitePortion;
    }

    public function setQuantitePortion(int $quantitePortion): self
    {
        $this->quantitePortion = $quantitePortion;

        return $this;
    }

    public function getMenus(): ?Menu
    {
        return $this->menus;
    }

    public function setMenus(?Menu $menus): self
    {
        $this->menus = $menus;

        return $this;
    }

    public function getPortionFrites(): ?PortionFrite
    {
        return $this->portionFrites;
    }

    public function setPortionFrites(?PortionFrite $portionFrites): self
    {
        $this->portionFrites = $portionFrites;

        return $this;
    }

}
