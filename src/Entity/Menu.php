<?php

namespace App\Entity;

use App\Entity\Burger;
use App\Entity\Taille;
use App\Entity\Produit;
use App\Entity\PortionFrite;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

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
            'denormalization_context' => ['groups' => ['write']],
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

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: BurgerMenu::class)]
    private $burgerMenus;

    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: MenuTaille::class)]
    private $menutailles;

    public function __construct()
    {
        $this->burgerMenus = new ArrayCollection();
        $this->menutailles = new ArrayCollection();
    }

    /**
     * @return Collection<int, BurgerMenu>
     */
    public function getBurgerMenus(): Collection
    {
        return $this->burgerMenus;
    }

    public function addBurgerMenus(BurgerMenu $burgerMenus): self
    {
        if (!$this->burgerMenus->contains($burgerMenus)) {
            $this->burgerMenus[] = $burgerMenus;
            $burgerMenus->setMenu($this);
        }

        return $this;
    }

    public function removeBurgerMenus(BurgerMenu $burgerMenus): self
    {
        if ($this->burgerMenus->removeElement($burgerMenus)) {
            // set the owning side to null (unless already changed)
            if ($burgerMenus->getMenu() === $this) {
                $burgerMenus->setMenu(null);
            }
        }

        return $this;
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


}
