<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ZoneRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get",
        "post" => [
            "access_control" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'denormalization_context' => ['groups' => ['write']],
            // 'denormalization_context' => ['groups' => ['zone']],
            'normalization_context' => ['groups' => ['zone:read:all']]
        ]
    ],
    itemOperations: [
        "get",
        "put"
    ]
)]
class Zone
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["write", "zone:read:all",'quartier','commande','comande:read'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["write", "zone:read:all",'quartier:read:all','comande:read'])]
    private $nom;

    #[ORM\Column(type: 'integer')]
    #[Groups(["write", "zone:read:all",'quartier:read:all'])]
    private $prix;
    
    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Quartiers::class,cascade:['persist'])]
    #[Groups(["write", "zone:read:all"])]
    private Collection $quartier;

    #[ORM\OneToMany(mappedBy: 'zone', targetEntity: Commande::class,cascade:['persist'])]
    private Collection $commandes;

       
    public function __construct()
    {
 
        $this->commandes = new ArrayCollection();
        $this->quartier = new ArrayCollection();
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
    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    /**
     * @return Collection<int, commande>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    /**
     * @return Collection<int, Quartiers>
     */
    public function getQuartier(): Collection
    {
        return $this->quartier;
    }

    public function addQuartier(Quartiers $quartier): self
    {
        if (!$this->quartier->contains($quartier)) {
            $this->quartier->add($quartier);
            $quartier->setZone($this);
        }

        return $this;
    }

    public function removeQuartier(Quartiers $quartier): self
    {
        if ($this->quartier->removeElement($quartier)) {
            // set the owning side to null (unless already changed)
            if ($quartier->getZone() === $this) {
                $quartier->setZone(null);
            }
        }

        return $this;
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
            $commande->setZone($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getZone() === $this) {
                $commande->setZone(null);
            }
        }

        return $this;
    }

}
