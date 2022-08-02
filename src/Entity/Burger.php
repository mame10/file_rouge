<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get"=>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['burger:read:simple']],
        ],
        "post" =>[
            // "access_control" => "is_granted('ROLE_GESTIONNAIRE')",
            // "security_message"=>"Vous n'avez pas access à cette Ressource",
            'denormalization_context' => ['groups' => ['write']],
            'normalization_context' => ['groups' => ['burger:read:all']]
        ]
    ],

    itemOperations:[
        "get"=>[
            'method' => 'get',
            'normalization_context' => ['groups' => ['burger:read:all']],
        ],
        "put"=>[
            'method' => 'put',
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",
            'status' => Response::HTTP_OK,
            'denormalization_context' => ['groups' => ['write']]
        ],
        "patch"
    ]
) ]
class Burger extends Produit
{
   
#[ORM\OneToMany(mappedBy: 'burger', targetEntity: BurgerCommande::class)]
    private Collection $burgerCommande;

#[ORM\OneToMany(mappedBy: 'burger', targetEntity: MenuBurger::class)]
private Collection $menuBurger;

    //    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: BurgerCommande::class,cascade:['persist'])]
//    private $burgerCommandes;

    public function __construct()
    {
        $this->burgerCommande = new ArrayCollection();
        $this->menuBurger = new ArrayCollection();  
    }

    /**
     * @return Collection<int, BurgerCommande>
     */
    public function getBurgerCommande(): Collection
    {
        return $this->burgerCommande;
    }

    public function addBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if (!$this->burgerCommande->contains($burgerCommande)) {
            $this->burgerCommande->add($burgerCommande);
            $burgerCommande->setBurger($this);
        }
        return $this;
    }

    public function removeBurgerCommande(BurgerCommande $burgerCommande): self
    {
        if ($this->burgerCommande->removeElement($burgerCommande)) {
            // set the owning side to null (unless already changed)
            if ($burgerCommande->getBurger() === $this) {
                $burgerCommande->setBurger(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurger(): Collection
    {
        return $this->menuBurger;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurger->contains($menuBurger)) {
            $this->menuBurger->add($menuBurger);
            $menuBurger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurger->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getBurger() === $this) {
                $menuBurger->setBurger(null);
            }
        }

        return $this;
    }

   

}
