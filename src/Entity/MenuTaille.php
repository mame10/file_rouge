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

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menutailles')]
    private $menu;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'tailleMenus')]
    #[Groups(["menu:write"])]
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
