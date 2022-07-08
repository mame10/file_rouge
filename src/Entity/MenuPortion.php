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
    #[Groups(["menu:write"])]
    private $quantitePortion;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuPortions')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'portionMenus')]
    #[Groups(["menu:write"])]
    private $portionFrite;

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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getPortionFrite(): ?PortionFrite
    {
        return $this->portionFrite;
    }

    public function setPortionFrite(?PortionFrite $portionFrite): self
    {
        $this->portionFrite = $portionFrite;

        return $this;
    }
}
