<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ApiResource(

    collectionOperations:[
        "post_register" => [
        "method"=>"post",
        'status' => Response::HTTP_CREATED,
        'path'=>'client/register',
        'denormalization_context' => ['groups' => ['user:write']],
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

class Client extends User
{
    #[Groups("user:write")]
    #[ORM\Column(type: 'string', length: 255)]
    private $adresse;

    #[Groups("user:write")]
    #[ORM\Column(type: 'string', length: 255)]
    private $telephone;

    #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    private Collection $commande;

    // #[ORM\OneToMany(mappedBy: 'client', targetEntity: Commande::class)]
    // // #[ApiSubresource]
    // private $commandes;

    public function __construct()
    {
        $this->setRoles(['ROLE_CLIENT']);
        $this->commande = new ArrayCollection();
    }


    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommande(): Collection
    {
        return $this->commande;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commande->contains($commande)) {
            $this->commande->add($commande);
            $commande->setClient($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commande->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

   
}
