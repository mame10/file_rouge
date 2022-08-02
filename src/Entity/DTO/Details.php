<?php

namespace App\Entity\DTO;

use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    collectionOperations:[],
    itemOperations:[
        "get"=>[
            'method'=>'get',
            // 'path'=>'/detail',
            'normalization_context'=>['groups'=>['details:read:all']]
        ]
    ]
)]
class Details{
    #[Groups('details:read:all')]
    public $id;

    #[Groups('details:read:all')]
    public $menu;

    #[Groups('details:read:all')]
    public $burger;

    #[Groups('details:read:all')]
    public array $boissons;

    #[Groups('details:read:all')]
    public array $portions;

}