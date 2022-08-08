<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeTailleBoissonRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeTailleBoissonRepository::class)]
class CommandeTailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('commande')]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups('commande')]
    private ?int $quantiteCommande = null;

    #[ORM\ManyToOne(inversedBy: 'commandeTailleBoissons')]
    private ?Commande $commande = null;

    #[ORM\ManyToOne(inversedBy: 'commandeTailleBoissons')]
    #[Groups('commande')]
    private ?TailleBoisson $boisson = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantiteCommande(): ?int
    {
        return $this->quantiteCommande;
    }

    public function setQuantiteCommande(int $quantiteCommande): self
    {
        $this->quantiteCommande = $quantiteCommande;

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

    public function getBoisson(): ?TailleBoisson
    {
        return $this->boisson;
    }

    public function setBoisson(?TailleBoisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }
}
