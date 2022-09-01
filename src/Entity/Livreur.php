<?php

namespace App\Entity;

use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get"=> [
            "method" => "get",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            "normalization_context" =>['groups' => ['write']]
        ],
        "post" => [
            "method" =>"post",
            "security" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'denormalization_context' => [ 'groups' => ['liv']]
         ]
    ],
    itemOperations: [
        "get","put"
    ]
)]
class Livreur extends User
{

    #[Groups(['liv','write','livraison'])]
    #[ORM\Column(type: 'string', length: 255)]
    private $telephone;

    #[Groups('write')]
    #[ORM\Column(type: 'string', length: 255)]
    private $etat = 'disponible';

    #[ORM\Column(length: 255)]
    #[Groups(['liv','write','livraison'])]
    private ?string $matricule = null;

    public function __construct()
    {
        $this->setRoles(['ROLE_LIVREUR']);
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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }
}
