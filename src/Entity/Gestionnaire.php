<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\GestionnaireRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: GestionnaireRepository::class)]
#[ApiResource(
    collectionOperations:[
        "post" => [
        "method"=>"post",
        'status' => Response::HTTP_CREATED,
        'denormalization_context' => ['groups' => ['write']],
        'normalization_context' => ['groups' => ['user:read:simple']]
        ],
        "get" => [
            "method" =>"get",
            'status'=>Response::HTTP_CREATED,
            'normalization_context' => ['groups' => ['user:read:all']]
        ]
    ],
    itemOperations:["put","get","delete"]
)]

class Gestionnaire extends User
{
    #[ORM\OneToMany(mappedBy: 'gestionnaire', targetEntity: Commande::class)]
    private $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->burgers = new ArrayCollection();
        $this->setRoles(['ROLE_GESTIONNAIRE']);
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setGestionnaire($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getGestionnaire() === $this) {
                $commande->setGestionnaire(null);
            }
        }
        return $this;
    }
}
