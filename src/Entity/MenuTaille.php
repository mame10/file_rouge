<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuTailleRepository;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuTailleRepository::class)]
#[ApiResource()]

class MenuTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["menu:write"])]
    private $id;
    

    #[ORM\Column(type: 'integer')]
    #[Groups(["menu:write"])]
    private $quantiteBoisson;

    // #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menutailles')]
    // private $menu;

    // #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'tailleMenus')]
    // #[Groups(["menu:write"])]
    // private $taille;

    #[ORM\ManyToOne(inversedBy: 'menuTailles')]
    private ?Menu $menus = null;

    #[ORM\ManyToOne(inversedBy: 'menuTailles')]
    #[Groups(["menu:write"])]
    private ?Taille $tailles = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteBoisson(): ?int
    {
        return $this->quantiteBoisson;
    }

    public function setQuantiteBoisson(int $quantiteBoisson): self
    {
        $this->quantiteBoisson = $quantiteBoisson;

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

    public function getTailles(): ?Taille
    {
        return $this->tailles;
    }

    public function setTailles(?Taille $tailles): self
    {
        $this->tailles = $tailles;

        return $this;
    }

    
}
