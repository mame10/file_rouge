<?php

namespace App\Entity;

use App\Repository\MenuTailleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MenuTailleRepository::class)]
class MenuTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantiteBoisson;

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menutailles')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'tailleMenus')]
    private $taille;

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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }
}
