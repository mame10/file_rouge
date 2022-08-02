<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuBurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MenuBurgerRepository::class)]
#[ApiResource]
class MenuBurger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups(["menu:write"])]
    #[Assert\Positive(message: "la quantité doit etre superieure à zero")]
    #[Assert\NotNull()]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Burger::class,inversedBy: 'menuBurger')]
    #[Groups(["menu:write"])]
    private $burger;

    #[ORM\ManyToOne(inversedBy: 'menuBurgers')]
    private ?Menu $menus = null;
    // #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuBurgers')]
    // #[Groups(["menu:write"])]
    // private $burger;

    // #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuBurgers')]
    // private $menu;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

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

   
}
