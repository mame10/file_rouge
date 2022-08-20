<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeTailleBoissonRepository;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommandeTailleBoissonRepository::class)]
#[ApiResource(
    collectionOperations:['get'],
    itemOperations:['get']
)]
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
    private ?TailleBoisson $tailleBoisson = null;

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

    /**
     * Get the value of tailleBoisson
     */ 
    public function getTailleBoisson()
    {
        return $this->tailleBoisson;
    }

    /**
     * Set the value of tailleBoisson
     *
     * @return  self
     */ 
    public function setTailleBoisson($tailleBoisson)
    {
        $this->tailleBoisson = $tailleBoisson;

        return $this;
    }
}
