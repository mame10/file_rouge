<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

#[ApiResource(
    collectionOperations:[
        "get" => [
        "method"=>"get",
        'status' => Response::HTTP_CREATED,
        'path'=>'catalogues',
        // 'denormalization_context' => ['groups' => ['user:write']],
        'normalization_context' => ['groups' => ['catologue']]
        ]
    ],
        itemOperations:[]
)]

class Catologues
{
    private $burgers;
    private $menus;

    public function __construct()
    {
        $this->burgers = new ArrayCollection();
        $this->menus = new ArrayCollection();
    }
}
