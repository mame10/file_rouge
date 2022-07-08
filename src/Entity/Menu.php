<?php

namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
// use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['menu:read:simple']],
        ],
        "post" => [
            "access_control" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'denormalization_context' => ['groups' => ['menu:write']],
            'normalization_context' => ['groups' => ['menu:read:all']]
        ]
    ],

    itemOperations: [
        "get" => [
            'method' => 'get',
            'normalization_context' => ['groups' => ['menu:read:all']],
        ],
        "put" => [
            'method' => 'put',
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'status' => Response::HTTP_OK,
            'denormalization_context' => ['groups' => ['write']],
            'normalization_context' => ['groups' => ["read"]]
        ],
        "patch"
    ]
)]

class Menu extends Produit
{

    #[Groups(["menu:write","menu:read:all"])]
    protected $nom;

    #[Groups(["menu:write","menu:read:all"])]
    protected $prix;

    #[Groups(["menu:write","menu:read:all"])]
    protected $image;
    

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class,cascade:['persist','remove'])]
    #[Groups(["menu:write"])]
    //#[SerializedName("taille")]
    private $menutailles;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuPortion::class,cascade:['persist','remove'])]
    #[Groups(["menu:write"])]
   // #[SerializedName("portion")]
    private $menuPortions;

    #[Assert\Valid()]
    #[Assert\NotBlank()]
    #[Assert\Count(
        min:1,
        minMessage:"le menu doit avoir au moins un burger"
    )]
    #[Groups(["menu:write"])]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuBurger::class,cascade:['persist','remove'])]
    private $menuBurgers;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuCommande::class)]
    private $menuCommandes;

    public function __construct()
    {
        $this->menutailles = new ArrayCollection();
        $this->menuPortions = new ArrayCollection();
        $this->menuBurgers = new ArrayCollection();
        $this->menuCommandes = new ArrayCollection();
    }

   
   /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenutailles(): Collection
    {
        return $this->menutailles;
    }

    public function addMenutaille(MenuTaille $menutaille): self
    {
        if (!$this->menutailles->contains($menutaille)) {
            $this->menutailles[] = $menutaille;
            $menutaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenutaille(MenuTaille $menutaille): self
    {
        if ($this->menutailles->removeElement($menutaille)) {
            // set the owning side to null (unless already changed)
            if ($menutaille->getMenu() === $this) {
                $menutaille->setMenu(null);
            }
        }

        return $this;
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
            $this->menuPortions[] = $menuPortion;
            $menuPortion->setMenu($this);
        }

        return $this;
    }

    public function removeMenuPortion(MenuPortion $menuPortion): self
    {
        if ($this->menuPortions->removeElement($menuPortion)) {
            // set the owning side to null (unless already changed)
            if ($menuPortion->getMenu() === $this) {
                $menuPortion->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuBurger>
     */
    public function getMenuBurgers(): Collection
    {
        return $this->menuBurgers;
    }

    public function addMenuBurger(MenuBurger $menuBurger): self
    {
        if (!$this->menuBurgers->contains($menuBurger)) {
            $this->menuBurgers[] = $menuBurger;
            $menuBurger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuBurger(MenuBurger $menuBurger): self
    {
        if ($this->menuBurgers->removeElement($menuBurger)) {
            // set the owning side to null (unless already changed)
            if ($menuBurger->getMenu() === $this) {
                $menuBurger->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MenuCommande>
     */
    public function getMenuCommandes(): Collection
    {
        return $this->menuCommandes;
    }

    public function addMenuCommande(MenuCommande $menuCommande): self
    {
        if (!$this->menuCommandes->contains($menuCommande)) {
            $this->menuCommandes[] = $menuCommande;
            $menuCommande->setMenu($this);
        }

        return $this;
    }

    public function removeMenuCommande(MenuCommande $menuCommande): self
    {
        if ($this->menuCommandes->removeElement($menuCommande)) {
            // set the owning side to null (unless already changed)
            if ($menuCommande->getMenu() === $this) {
                $menuCommande->setMenu(null);
            }
        }

        return $this;
    }


}
