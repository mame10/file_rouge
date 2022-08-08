<?php
namespace App\Entity;

use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BoissonRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BoissonRepository::class)]
#[ApiResource(
    collectionOperations:[
        "get" =>[
            'method' => 'get',
            'status' => Response::HTTP_OK,
            'normalization_context' => ['groups' => ['boisson:read:simple']],
        ],
        "post" =>[
            "access_control" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",
            'denormalization_context' => ['groups' => ['write']],
            'normalization_context' => ['groups' => ['boisson:read:all']]
        ]
    ],

    itemOperations:[
        "put"=>[
            'method' => 'put',
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message"=>"Vous n'avez pas access à cette Ressource",
            'status' => Response::HTTP_OK,
            'denormalization_context' => ['groups' => ['write']]
        ],
        "get"=>[
            'method' => 'get',
            'normalization_context' => ['groups' => ['boisson:read:all']]
        ],
        "patch"
    ]
) ] 
 
class Boisson extends Produit
{

    #[ORM\OneToMany(mappedBy: 'boisson', targetEntity: TailleBoisson::class,cascade:['persist'])]
    #[Groups('boisson:read:all')]
    private $tailleBoisson;

    public function __construct()
    {
        $this->tailleBoisson = new ArrayCollection();
    }

    /**
     * @return Collection<int, TailleBoisson>
     */
    public function getTailleBoisson(): Collection
    {
        return $this->tailleBoisson;
    }

    public function addTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if (!$this->tailleBoisson->contains($tailleBoisson)) {
            $this->tailleBoisson->add($tailleBoisson);
            $tailleBoisson->setBoisson($this);
        }

        return $this;
    }

    public function removeTailleBoisson(TailleBoisson $tailleBoisson): self
    {
        if ($this->tailleBoisson->removeElement($tailleBoisson)) {
            // set the owning side to null (unless already changed)
            if ($tailleBoisson->getBoisson() === $this) {
                $tailleBoisson->setBoisson(null);
            }
        }
        return $this;
    }
}
