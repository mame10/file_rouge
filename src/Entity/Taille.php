<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get" => [
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['taille:read:simple']],
        ],
        "post" => [
            "access_control" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'denormalization_context' => ['groups' => ['write']],
            'normalization_context' => ['groups' => ['taille:read:all']]
        ]
    ],

    itemOperations: [
        "get" => [
            'method' => 'get',
            'normalization_context' => ['groups' => ['taille:read:all']],
        ],
        "put" => [
            'method' => 'put',
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'status' => Response::HTTP_OK,
            'denormalization_context' => ['groups' => ['write']]
        ],
        "patch"
    ]
)]
class Taille
{

    // #[Groups(["boisson:read:all","write","taille:read:all","complements"])]
    #[Groups(['details:read:all',"menu:write", "boisson:read:all", "write", "taille:read:all", "complements"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[Groups(['details:read:all',"write","taille:read:all", "complements"])]
    #[ORM\Column(type: 'integer',)]
    private $prix;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(['details:read:all',"write","taille:read:all", "complements"])]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'tailles', targetEntity: MenuTaille::class)]
    private Collection $menuTailles;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: TailleBoisson::class)]
    #[Groups('details:read:all')]
    private Collection $tailleBoissons;

    // #[ORM\ManyToMany(targetEntity: Boisson::class, inversedBy: 'tailles')]
    // private $boissons;

    // #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenuTaille::class)]
    // private $tailleMenus;

    // #[ORM\OneToMany(mappedBy: 'taille', targetEntity: TailleBoisson::class, cascade: ['persist'])]
    // private $tailleBoissons;



    public function __construct()
    {

        // $this->boissons = new ArrayCollection();
        // $this->tailleMenus = new ArrayCollection();
        // $this->tailleMenus = new ArrayCollection();
        // $this->tailleBoissons = new ArrayCollection();
        $this->menuTailles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * @return Collection<int, MenuTaille>
     */
    public function getMenuTailles(): Collection
    {
        return $this->menuTailles;
    }

    public function addMenuTaille(MenuTaille $menuTaille): self
    {
        if (!$this->menuTailles->contains($menuTaille)) {
            $this->menuTailles->add($menuTaille);
            $menuTaille->setTailles($this);
        }

        return $this;
    }

    public function removeMenuTaille(MenuTaille $menuTaille): self
    {
        if ($this->menuTailles->removeElement($menuTaille)) {
            // set the owning side to null (unless already changed)
            if ($menuTaille->getTailles() === $this) {
                $menuTaille->setTailles(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleBoissons(): Collection
    {
        return $this->tailleBoissons;
    }

    public function addTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if (!$this->tailleBoissons->contains($tailleBoisson)) {
            $this->tailleBoissons->add($tailleBoisson);
            $tailleBoisson->setTaille($this);
        }

        return $this;
    }

    public function removeTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if ($this->tailleBoissons->removeElement($tailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($tailleBoisson->getTaille() === $this) {
                $tailleBoisson->setTaille(null);
            }
        }

        return $this;
    }

   
}
