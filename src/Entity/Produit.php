<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
// use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;


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
    #[Groups(['catologue','details:read:all',"burger:read:simple", "burger:read:all", "user:read:simple", "boisson:read:all", "portion:read:all", "menu:read:all", "write", "menu:read:simple", 'menu:write'])]
    protected $id;

    #[Groups(['details:read:all',"burger:read:simple", "burger:read:all", "boisson:read:all", "portion:read:all", "write", "complements", "catologue", "menu:write", 'menu:read:all'])]
    #[ORM\Column(type: 'string', length: 255)]
    // #[Assert\Unique(message: "Le nom est du produit est unique")]
    protected $nom;

    #[ORM\Column(type: 'blob')]
    #[Groups(['details:read:all','menu:read:all', "burger:read:simple", "burger:read:all", "boisson:read:all", "portion:read:all", "complements", "catologue"])]
    protected $image;

    #[Groups(['details:read:all','details:read:all', 'menu:read:all', "burger:read:simple", "burger:read:all", "boisson:read:all", "portion:read:all", "write", "complements", "catologue", "menu:write"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    // #[Assert\NotNull(message: "Le prix ne doit etre nul!!")]
    protected $prix;

    #[ORM\Column(type: 'boolean')]
    #[Groups(['details:read:all','menu:read:all', "burger:read:all", "boisson:read:all", "complements", "catologue", "menu:read:all"])]
    protected $isEtat = true;

    // #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    // private $gestionnaire;

    #[SerializedName('images')]
    #[Groups(["burger:read:simple", "menu:write", "burger:read:all", "boisson:read:all", "boisson:read:simple", "portion:read:all", "portion:read:simple", "write"])]
    private string $imageFile;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: ProduitCommande::class)]
    private Collection $produitCommandes;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'produits')]
    private $user;

    

    public function __construct()
    {
        $this->produitCommandes = new ArrayCollection();
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
        if (is_resource($this->image)) {
            return base64_encode(stream_get_contents($this->image));
        }
        return base64_encode($this->image);
    }

    public function setImage($image): self
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

    public function getImageFile(): ?string
    {
        return $this->imageFile;
    }

    public function setImageFile(string $imageFile): self
    {
        $this->imageFile = $imageFile;
        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    /**
     * @return Collection<int, ProduitCommande>
     */
    public function getProduitCommandes(): Collection
    {
        return $this->produitCommandes;
    }

    public function addProduitCommande(ProduitCommande $produitCommande): self
    {
        if (!$this->produitCommandes->contains($produitCommande)) {
            $this->produitCommandes->add($produitCommande);
            $produitCommande->setProduit($this);
        }

        return $this;
    }

    public function removeProduitCommande(ProduitCommande $produitCommande): self
    {
        if ($this->produitCommandes->removeElement($produitCommande)) {
            // set the owning side to null (unless already changed)
            if ($produitCommande->getProduit() === $this) {
                $produitCommande->setProduit(null);
            }
        }

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

}
