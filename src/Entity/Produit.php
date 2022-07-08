<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
// use Symfony\Component\Validator\Constraints as Assert;


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
    #[Groups(["menu:write","burger:read:simple", "burger:read:all", "user:read:simple", "boisson:read:all", "portion:read:all", "write"])]
    protected $id;

    #[Groups(["burger:read:simple", "burger:read:all", "boisson:read:all", "portion:read:all", "write", "complements", "catologue"])]
    #[ORM\Column(type: 'string', length: 255)]
    // #[Assert\Unique(message: "Le nom est du produit est unique")]
    protected $nom;

    #[ORM\Column(type: 'blob')]
    protected $image;

    #[Groups(["burger:read:simple", "burger:read:all", "boisson:read:all", "portion:read:all","write", "complements", "catologue"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    // #[Assert\NotNull(message: "Le prix ne doit etre nul!!")]
    protected $prix;

    #[ORM\Column(type: 'boolean')]
    #[Groups(["burger:read:all", "boisson:read:all", "complements","catologue","menu:read:all"])]
    protected $isEtat = true;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    private $gestionnaire;

   #[SerializedName('image')]
   #[Groups(["burger:read:simple", "burger:read:all", "boisson:read:all","boisson:read:simple","portion:read:all","portion:read:simple","write",])]
    private $imageFile;

    public function __construct()
    {
        
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

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

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

}
