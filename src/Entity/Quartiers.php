<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartiersRepository;
use ApiPlatform\Core\Annotation\ApiResource;


use ApiPlatform\Core\Annotation\ApiSubresource;

use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuartiersRepository::class)]
#[ApiResource(
    collectionOperations: [
        "get",
        "post" => [
            "access_control" => "is_granted('ROLE_GESTIONNAIRE')",
            "security_message" => "Vous n'avez pas access à cette Ressource",
            'denormalization_context' => ['groups' => ['quartier']],
            'normalization_context' => ['groups' => ['quartier:read:all']]
        ]
    ],
    itemOperations: [
        "get",
        "put",
    ]
)]
class Quartiers
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["write", "zone:read:all",'quartier','quartier:read:all'])]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Groups(["write", "zone:read:all",'quartier','quartier:read:all'])]
    private $libelle;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartier')]
    #[Groups(['quartier','quartier:read:all'])]
    private $zone;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;
        return $this;
    }

   
}
