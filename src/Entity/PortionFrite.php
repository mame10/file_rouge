<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PortionFriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: PortionFriteRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['portion:read:simple']]
        ],

        "post" => [
            "access_control" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'denormalization_context' => ['groups' => ['write']],
            'normalization_context' => ['groups' => ['portion:read:all']]
        ]
    ],
    itemOperations: [
        "put", "get"
    ]
)]
class PortionFrite extends Produit
{

    #[ORM\OneToMany(mappedBy: 'portionFrites', targetEntity: MenuPortion::class,cascade:['persist'])]
    private Collection $menuPortions;

    #[ORM\OneToMany(mappedBy: 'portions', targetEntity: PortionCommande::class,cascade:['persist'])]
    private Collection $portionCommandes;

    public function __construct()
    {
        $this->portionCommandes = new ArrayCollection();
        $this->menuPortions = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuPortion>
     */
    public function getMenuPortions(): Collection
    {
        return $this->menuPortions;
    }

    public function addMenuPortion(MenuPortion $menuPortion): self
    {
        if (!$this->menuPortions->contains($menuPortion)) {
            $this->menuPortions->add($menuPortion);
            $menuPortion->setPortionFrites($this);
        }

        return $this;
    }

    public function removeMenuPortion(MenuPortion $menuPortion): self
    {
        if ($this->menuPortions->removeElement($menuPortion)) {
            // set the owning side to null (unless already changed)
            if ($menuPortion->getPortionFrites() === $this) {
                $menuPortion->setPortionFrites(null);
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
            $portionCommande->setPortions($this);
        }

        return $this;
    }

    public function removePortionCommande(PortionCommande $portionCommande): self
    {
        if ($this->portionCommandes->removeElement($portionCommande)) {
            // set the owning side to null (unless already changed)
            if ($portionCommande->getPortions() === $this) {
                $portionCommande->setPortions(null);
            }
        }

        return $this;
    }

   
}
