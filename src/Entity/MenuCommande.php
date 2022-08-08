<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuCommandeRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: MenuCommandeRepository::class)]
#[ApiResource()]
class MenuCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('commande')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups('commande')]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Menu::class,inversedBy: 'menuCommandes')]
    #[Groups('commande')]
    private $menus;

    #[ORM\ManyToOne(targetEntity: Commande::class,inversedBy: 'menuCommandes')]
    private $commandes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

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

    public function getCommandes(): ?Commande
    {
        return $this->commandes;
    }

    public function setCommandes(?Commande $commandes): self
    {
        $this->commandes = $commandes;

        return $this;
    }

   
}
