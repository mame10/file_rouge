<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
// use ApiPlatform\Core\Annotation\ApiSubresource;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\Cascade;

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
            "get","patch"
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
    #[Groups('comande:read')]
    private $numero;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('comande:read')]
    private $date;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups('comande:read')]
    private $etat='En_cours';

    #[ORM\Column(type: 'integer')]
    #[Groups('comande:read')]
    private $montant;

    #[ORM\OneToMany(mappedBy: 'commandes', targetEntity: BurgerCommande::class,cascade:(['persist']))]
    #[Groups('commande')]
    private Collection $burgerCommandes;

    #[ORM\OneToMany(mappedBy: 'commandes', targetEntity: MenuCommande::class,cascade:['persist'])]
    #[Groups('commande')]
    private Collection $menuCommandes;

    #[ORM\OneToMany(mappedBy: 'commandes', targetEntity: PortionCommande::class,cascade:['persist'])]
    #[Groups('commande')]
    private Collection $portionCommandes;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commande')]
    #[Groups('commande','comande-read')]
    private $zone ;

    #[ORM\ManyToOne(targetEntity: Client::class,inversedBy: 'commande')]
    #[Groups('comande:read')]
    private  $client ;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    private ?Gestionnaire $gestionnaire = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeTailleBoisson::class,cascade:['persist'])]
    #[Groups('commande')]
    private Collection $commandeTailleBoissons;

    public function __construct()
    {
        $this->burgerCommandes = new ArrayCollection();
        $this->portionCommandes = new ArrayCollection();
        $this->menuCommandes = new ArrayCollection();
        $this->boissonCommandes = new ArrayCollection();
        $this->date = new \DateTime();
        $this->numero = "NUM".date('ymdhis');
        $this->commandeTailleBoissons = new ArrayCollection();

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
            $this->burgerCommandes->add($burgerCommande);
            $burgerCommande->setCommandes($this);
        }

        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if ($this->burgerCommandes->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getCommandes() === $this) {
                $burgerCommande->setCommandes(null);
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
            $this->menuCommandes->add($menuCommande);
            $menuCommande->setCommandes($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self
    {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getCommandes() === $this) {
                $menuCommande->setCommandes(null);
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
            $this->portionCommandes->add($portionCommande);
            $portionCommande->setCommandes($this);
        }

        return $this;
    }

    public function removePortionCommande(PortionCommande $portionCommande): self
    {
        if ($this->portionCommandes->removeElement($portionCommande)) {
            // set the owning side to null (unless already changed)
            if ($portionCommande->getCommandes() === $this) {
                $portionCommande->setCommandes(null);
            }
        }

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

    public function getZones(): ?Zone
    {
        return $this->zones;
    }

    public function setZones(?Zone $zones): self
    {
        $this->zones = $zones;

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
     * @return Collection<int, CommandeTailleBoisson>
     */
    public function getCommandeTailleBoissons(): Collection
    {
        return $this->commandeTailleBoissons;
    }

    public function addCommandeTailleBoisson(CommandeTailleBoisson $commandeTailleBoisson): self
    {
        if (!$this->commandeTailleBoissons->contains($commandeTailleBoisson)) {
            $this->commandeTailleBoissons->add($commandeTailleBoisson);
            $commandeTailleBoisson->setCommande($this);
        }

        return $this;
    }

    public function removeCommandeTailleBoisson(CommandeTailleBoisson $commandeTailleBoisson): self
    {
        if ($this->commandeTailleBoissons->removeElement($commandeTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($commandeTailleBoisson->getCommande() === $this) {
                $commandeTailleBoisson->setCommande(null);
            }
        }

        return $this;
    }

    
}
