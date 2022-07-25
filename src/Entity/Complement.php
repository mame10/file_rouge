<?php

namespace App\Entity;

use App\Repository\ComplementRepository;
use Doctrine\ORM\Mapping as ORM;


class Complement
{

    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
