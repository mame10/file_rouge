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
    collectionOperations:[
        "get"=>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['portion:read:simple']]
        ],
        
        "post"=>[
            "access_control" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",
            'denormalization_context' => ['groups' => ['write']],
            'normalization_context' => ['groups' => ['portion:read:all']]
        ]
    ],
    itemOperations:[
        "put"
        ,"get"
    ]
)]
class PortionFrite extends Produit
{

    #[ORM\OneToMany(mappedBy: 'portionFrite', targetEntity: MenuPortion::class)]
    private $portionMenus;

    #[ORM\OneToMany(mappedBy: 'portion', targetEntity: PortionCommande::class)]
    private $portionCommandes;

    public function __construct()
    {
        $this->portionMenus = new ArrayCollection();
        $this->portionCommandes = new ArrayCollection();
    }

    /**
     * @return Collection<int, MenuPortion>
     */
    public function getPortionMenus(): Collection
    {
        return $this->portionMenus;
    }

    public function addPortionMenu(MenuPortion $portionMenu): self
    {
        if (!$this->portionMenus->contains($portionMenu)) {
            $this->portionMenus[] = $portionMenu;
            $portionMenu->setPortionFrite($this);
        }

        return $this;
    }

    public function removePortionMenu(MenuPortion $portionMenu): self
    {
        if ($this->portionMenus->removeElement($portionMenu)) {
            // set the owning side to null (unless already changed)
            if ($portionMenu->getPortionFrite() === $this) {
                $portionMenu->setPortionFrite(null);
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
            $portionCommande->setPortion($this);
        }

        return $this;
    }

    public function removePortionCommande(PortionCommande $portionCommande): self
    {
        if ($this->portionCommandes->removeElement($portionCommande)) {
            // set the owning side to null (unless already changed)
            if ($portionCommande->getPortion() === $this) {
                $portionCommande->setPortion(null);
            }
        }

        return $this;
    }

 

}
