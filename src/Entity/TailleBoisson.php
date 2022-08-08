<?php

namespace App\Entity;

use App\Repository\TailleBoissonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: TailleBoissonRepository::class)]
class TailleBoisson
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups('commande')]
    private $id;

    #[ORM\Column(type: 'float')]
    #[Groups('details:read:all')]
    #[SerializedName('quantiteStock')]
    private $quantite;

    #[ORM\ManyToOne(inversedBy: 'tailleBoisson')]
    #[Groups('details:read:all','commande')]
    private ?Boisson $boisson = null;

    #[ORM\ManyToOne(inversedBy: 'tailleBoissons')]
    #[Groups('commande','boisson:read:all')]
    private ?Taille $taille = null;

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: CommandeTailleBoisson::class,cascade:['persist'])]
    private Collection $commandeTailleBoissons;

    public function __construct()
    {
        $this->commandeTailleBoissons = new ArrayCollection();
    }


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
            $commandeTailleBoisson->setBoisson($this);
        }

        return $this;
    }

    public function removeCommandeTailleBoisson(CommandeTailleBoisson $commandeTailleBoisson): self
    {
        if ($this->commandeTailleBoissons->removeElement($commandeTailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($commandeTailleBoisson->getBoisson() === $this) {
                $commandeTailleBoisson->setBoisson(null);
            }
        }

        return $this;
    }

   
}
