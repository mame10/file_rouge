<?php

namespace App\Entity;

use App\Repository\ProduitCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitCommandeRepository::class)]
class ProduitCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantiteProduit;

    #[ORM\ManyToOne(targetEntity: Commande::class,inversedBy: 'produitCommandes')]
    private $commande ;

    #[ORM\ManyToOne(targetEntity: Produit::class,inversedBy: 'produitCommandes')]
    private $produit;

    // #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'produitCommende')]
    // private $user;

    // #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'produitCommandes')]
    // private $commande;

    // #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'produitCommande')]
    // private $produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteProduit(): ?int
    {
        return $this->quantiteProduit;
    }

    public function setQuantiteProduit(int $quantiteProduit): self
    {
        $this->quantiteProduit = $quantiteProduit;
        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

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
