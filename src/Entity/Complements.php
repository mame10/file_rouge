<?php

namespace App\Entity;

use App\Entity\Taille;
use App\Entity\PortionFrite;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComplementsRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ComplementsRepository::class)]
#[ApiResource]
class Complements
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToMany(mappedBy: 'complements', targetEntity: PortionFrite::class)]
    private $portions;

    #[ORM\OneToMany(mappedBy: 'complements', targetEntity: Taille::class)]
    private $boissons;

    public function __construct()
    {
        $this->portions = new ArrayCollection();
        $this->boissons = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getPortions(): Collection
    {
        return $this->portions;
    }

    public function addPortion(PortionFrite $portion): self
    {
        if (!$this->portions->contains($portion)) {
            $this->portions[] = $portion;
            $portion->setComplements($this);
        }

        return $this;
    }

    public function removePortion(PortionFrite $portion): self
    {
        if ($this->portions->removeElement($portion)) {
            // set the owning side to null (unless already changed)
            if ($portion->getComplements() === $this) {
                $portion->setComplements(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Taille $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
            $boisson->setComplements($this);
        }

        return $this;
    }

    public function removeBoisson(Taille $boisson): self
    {
        if ($this->boissons->removeElement($boisson)) {
            // set the owning side to null (unless already changed)
            if ($boisson->getComplements() === $this) {
                $boisson->setComplements(null);
            }
        }

        return $this;
    }
}
