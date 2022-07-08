<?php

namespace App\Entity;

use App\Entity\Taille;
use App\Entity\PortionFrite;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations:["get"=>[ 'method' => 'get',
        'status' => Response::HTTP_OK,
        'normalization_context' => ['groups' => ['complements']]
         ]
    ],
    itemOperations:[]
)]

class Complements
{

    #[Groups(["complements"])]
    private $portions;
    #[Groups(["complements"])]
    private $tailles;
    public function __construct()
    {
        $this->portions = new ArrayCollection();
        $this->tailles = new ArrayCollection();
    }

    /**
     * @return Collection<int, PortionFrite>
     */
    public function getPortions(): Collection
    {
        return $this->portions;
    }

    public function addPortion(PortionFrite $portion): self
    {
        if (!$this->portions->contains($portion)) {
            $this->portions[] = $portion;
        }
        return $this;
    }

    /**
     * @return Collection<int, Taille>
     */
    public function getTailles(): Collection
    {
        return $this->tailles;
    }

    public function addTaille(Taille $taille): self
    {
        if (!$this->tailles->contains($taille)) {
            $this->tailles[] = $taille;
        }
        return $this;
    }

}
