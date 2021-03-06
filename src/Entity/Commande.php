<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Date;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get",
        "post" => [
        "method"=>"post",
        'denormalization_context' => ['groups' => ['commande']],
        'normalization_context' => ['groups' => ['comande:read']]
        ]
    ],
        itemOperations:[
            "get","path"
        ]
)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('commande','comande:read')]
    private $id;

    #[ORM\Column(type: 'integer')]
    #[Groups('commande','comande:read')]
    private $numero;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('comande:read')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('comande:read')]
    private $etat='En_cours';

    #[ORM\Column(type: 'integer')]
    #[Groups('commande','comande:read')]
    private $montant;

    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes')]
    private $livraison;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes')]
    #[ApiSubresource()]
    #[Groups('commande')]
    private $client;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes')]
    #[Groups('commande')]
    private $gestionnaire;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BurgerCommande::class)]
    #[Groups('commande')]
    private $burgerCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: PortionCommande::class)]
    #[Groups('commande')]
    private $portionCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: MenuCommande::class)]
    #[Groups('commande')]
    private $menuCommandes;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: BoissonCommande::class)]
    #[Groups('commande')]
    private $boissonCommandes;

    public function __construct()
    {
        $this->burgerCommandes = new ArrayCollection();
        $this->portionCommandes = new ArrayCollection();
        $this->menuCommandes = new ArrayCollection();
        $this->boissonCommandes = new ArrayCollection();
        $this->date = new \DateTime();

    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getDate(): ?DateTime
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMontant(): ?int
    {
        return $this->montant;
    }

    public function setMontant(int $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

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
     * @return Collection<int, BurgerCommande>
     */
    public function getBurgerCommandes(): Collection
    {
        return $this->burgerCommandes;
    }

    public function addBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if (!$this->burgerCommandes->contains($burgerCommande)) {
            $this->burgerCommandes[] = $burgerCommande;
            $burgerCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if ($this->burgerCommandes->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getCommande() === $this) {
                $burgerCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PortionCommande>
     */
    public function getPortionCommandes(): Collection
    {
        return $this->portionCommandes;
    }

    public function addPortionCommande(PortionCommande $portionCommande): self
    {
        if (!$this->portionCommandes->contains($portionCommande)) {
            $this->portionCommandes[] = $portionCommande;
            $portionCommande->setCommande($this);
        }

        return $this;
    }

    public function removePortionCommande(PortionCommande $portionCommande): self
    {
        if ($this->portionCommandes->removeElement($portionCommande)) {
            // set the owning side to null (unless already changed)
            if ($portionCommande->getCommande() === $this) {
                $portionCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuCommande>
     */
    public function getMenuCommandes(): Collection
    {
        return $this->menuCommandes;
    }

    public function addMenuCommande(MenuCommande $menuCommande): self
    {
        if (!$this->menuCommandes->contains($menuCommande)) {
            $this->menuCommandes[] = $menuCommande;
            $menuCommande->setCommande($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self
    {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getCommande() === $this) {
                $menuCommande->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoissonCommande>
     */
    public function getBoissonCommandes(): Collection
    {
        return $this->boissonCommandes;
    }

    public function addBoissonCommande(BoissonCommande $boissonCommande): self
    {
        if (!$this->boissonCommandes->contains($boissonCommande)) {
            $this->boissonCommandes[] = $boissonCommande;
            $boissonCommande->setCommande($this);
        }

        return $this;
    }

    public function removeBoissonCommande(BoissonCommande $boissonCommande): self
    {
        if ($this->boissonCommandes->removeElement($boissonCommande)) {
            // set the owning side to null (unless already changed)
            if ($boissonCommande->getCommande() === $this) {
                $boissonCommande->setCommande(null);
            }
        }

        return $this;
    }
 
}
