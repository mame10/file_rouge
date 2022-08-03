<?php

namespace App\Entity;

use App\Repository\TailleBoissonRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups('details:read:all')]
    #[SerializedName('quantiteStock')]
    private $quantite;

    #[ORM\ManyToOne(inversedBy: 'tailleBoisson')]
    #[Groups('details:read:all')]
    private ?Boisson $boisson = null;

    #[ORM\ManyToOne(inversedBy: 'tailleBoissons')]
    private ?Taille $taille = null;

    // #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'tailleBoissons')]
    // private $boisson;

    // #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'tailleBoissons')]
    // private $taille;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantite(): ?float
    {
        return $this->quantite;
    }

    public function setQuantite(float $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

   
}