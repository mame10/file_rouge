<?php
namespace App\Services;

use App\Entity\Commande;

interface ICalculPriceCommandeService{

    public function PriceCommande(Commande $data):float;

}