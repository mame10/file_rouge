<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\InheritanceType("JOINED")]
#[ORM\DiscriminatorColumn(name: "discr", type: "string")]
#[ORM\DiscriminatorMap(["produit" => "Produit", "burger" => "Burger", "boisson" => "Boisson", "portionFrite" => "PortionFrite", "menu" => "Menu"])]
#[ApiResource(
    collectionOperations: ["get", "post"],
    itemOperations: ["put", "get"]
)]

#[ORM\Entity(repositoryClass: ProduitRepository::class)]

class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["burger:read:simple", "burger:read:all", "user:read:simple", "boisson:read:all", "portion:read:all", "menu:read:all", "write", "menu:read:simple"])]
    protected $id;

    #[Groups(["burger:read:simple", "burger:read:all", "boisson:read:all", "portion:read:all", "menu:read:all", "write", "complements", "menu:read:simple", "catologue"])]
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank(message: "Le nom est Obligatoire")]
    private $nom;

    #[ORM\Column(type: 'object')]
    private $image;

    #[Groups(["burger:read:simple", "burger:read:all", "boisson:read:all", "portion:read:all", "menu:read:all", "write", "complements", "menu:read:simple", "catologue"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    // #[Assert\NotBlank(message: "Le prix est Obligatoire")]
    private $prix;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["burger:read:all", "boisson:read:all", "menu:read:all", "complements", "catologue"])]
    private $isEtat = true;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'produits')]
    #[Groups(["burger:read:all", "boisson:read:all", "write"])]
    #[ApiSubresource]
    private $user;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitCommande::class)]
    private $produitCommande;
    public function __construct()
    {
        $this->produitCommande = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getImage()
    {
        if ($this->image) {
            return (base64_encode(stream_get_contents($this->image)));
        }
        // return $this->image;
    }

    public function setImage(object $image): self
    {
        $this->image = $image;

        return $this;
    }


    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function isIsEtat(): ?bool
    {
        return $this->isEtat;
    }

    public function setIsEtat(bool $isEtat): self
    {
        $this->isEtat = $isEtat;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Collection<int, ProduitCommande>
     */
    public function getProduitCommande(): Collection
    {
        return $this->produitCommande;
    }

    public function addProduitCommande(ProduitCommande $produitCommande): self
    {
        if (!$this->produitCommande->contains($produitCommande)) {
            $this->produitCommande[] = $produitCommande;
            $produitCommande->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommande->removeElement($produitCommande)) {
            // set the owning side to null (unless already changed)
            if ($produitCommande->getProduit() === $this) {
                $produitCommande->setProduit(null);
            }
        }

        return $this;
    }

}
