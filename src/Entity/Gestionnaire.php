<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    collectionOperations:[
        "post" => [
            "method"=>"post",
            'status' => Response::HTTP_CREATED,
            'denormalization_context' => ['groups' => ['write']],
            'normalization_context' => ['groups' => ['user:read:simple']]
        ],
        "get" => [
            "method" =>"get",
            'status'=>Response::HTTP_CREATED,
            'normalization_context' => ['groups' => ['user:read:all']]
        ]
    ],
    itemOperations:["put","get","delete"]
)]

class Gestionnaire extends User
{
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Commande::class)]
    private Collection $commandes;

    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    private Collection $produits;

    // #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Commande::class)]
    // private $commandes;

    // #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Produit::class)]
    // private $produits;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->setRoles(['ROLE_GESTIONNAIRE']);
        $this->produits = new ArrayCollection();
      
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->setGestionnaire($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getGestionnaire() === $this) {
                $commande->setGestionnaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Produit>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits->add($produit);
            $produit->setGestionnaire($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getGestionnaire() === $this) {
                $produit->setGestionnaire(null);
            }
        }

        return $this;
    }

}
