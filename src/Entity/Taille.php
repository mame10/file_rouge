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

    #[Groups(["menu:write","boisson:read:all","write","taille:read:all","complements"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["taille:read:all","complements","write"])]
    #[ORM\Column(type: 'integer',nullable:true)]
    private $prix;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["taille:read:all","complements","write"])]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: MenuTaille::class,cascade:["persist"])]
    private $tailleMenus;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: TailleBoisson::class,cascade:['persist'])]
    private $tailleBoissons;

   
    public function __construct()
    {
        $this->tailleMenus = new ArrayCollection();
        $this->tailleBoissons = new ArrayCollection();
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
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }


    /**
     * @return Collection<int, MenuTaille>
     */
    public function getTailleMenus(): Collection
    {
        return $this->tailleMenus;
    }

    public function addTailleMenu(MenuTaille $tailleMenu): self
    {
        if (!$this->tailleMenus->contains($tailleMenu)) {
            $this->tailleMenus[] = $tailleMenu;
            $tailleMenu->setTaille($this);
        }

        return $this;
    }

    public function removeTailleMenu(MenuTaille $tailleMenu): self
    {
        if ($this->tailleMenus->removeElement($tailleMenu)) {
            // set the owning side to null (unless already changed)
            if ($tailleMenu->getTaille() === $this) {
                $tailleMenu->setTaille(null);
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
            $this->tailleBoissons[] = $tailleBoisson;
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
