<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PortionCommandeRepository;

#[ORM\Entity(repositoryClass: PortionCommandeRepository::class)]
#[ApiResource()]

class PortionCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\ManyToOne(inversedBy: 'portionCommandes')]
    private ?PortionFrite $portions = null;

    #[ORM\ManyToOne(inversedBy: 'portionCommandes')]
    private ?Commande $commandes = null;

    #[ORM\ManyToOne(inversedBy: 'produitCommande')]
    private ?Produit $produit = null;

    // #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'portionCommandes')]
    // private $portion;

    // #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'portionCommandes')]
    // private $commande;

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

    public function getPortions(): ?PortionFrite
    {
        return $this->portions;
    }

    public function setPortions(?PortionFrite $portions): self
    {
        $this->portions = $portions;

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

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    
}
