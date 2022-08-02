<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BoissonCommandeRepository;

#[ORM\Entity(repositoryClass: BoissonCommandeRepository::class)]
#[ApiResource()]
class BoissonCommande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $quantite;

    #[ORM\ManyToOne(targetEntity: Boisson::class,inversedBy: 'boissonCommandes')]
    private $boissons ;

    #[ORM\ManyToOne(targetEntity: Commande::class,inversedBy: 'boissonCommandes')]
    private $commande ;

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

    public function getBoissons(): ?Boisson
    {
        return $this->boissons;
    }

    public function setBoissons(?Boisson $boissons): self
    {
        $this->boissons = $boissons;

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

}
