<?php
namespace App\Services;

use App\Entity\Menu;


class CalculPriceMenu 
{

    public function __construct(){
      
       
    }
   
    public function PriceMenu($data){
        $prix=0;
        foreach ($data->getBurgers() as $burger) {
            $prix += $burger->getPrix();
        }
        foreach ($data->getTailles() as $taille) {
            $prix += $taille->getPrix();
        }
        foreach ($data->getPortions() as $portion) {
            $prix+= $portion->getPrix();
        }
        $data->setPrix($prix);
    }
     
}
