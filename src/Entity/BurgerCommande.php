<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BurgerCommandeRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerCommandeRepository::class)]
#[ApiResource()]
class BurgerCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('commande')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups('commande')]
    private $quantity;

    #[ORM\ManyToOne(targetEntity: Burger::class,inversedBy: 'burgerCommande')]
    #[Groups('commande')]
    private $burger;

    #[ORM\ManyToOne(targetEntity: Commande::class,inversedBy: 'burgerCommandes')]
    private $commandes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

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
