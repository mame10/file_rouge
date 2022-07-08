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

    #[ORM\ManyToOne(targetEntity: PortionFrite::class, inversedBy: 'portionCommandes')]
    private $portion;

    #[ORM\ManyToOne(targetEntity: Commande::class, inversedBy: 'portionCommandes')]
    private $commande;

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

    public function getPortion(): ?PortionFrite
    {
        return $this->portion;
    }

    public function setPortion(?PortionFrite $portion): self
    {
        $this->portion = $portion;

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
