<?php

namespace App\Services;

use App\Entity\Menu;
use phpDocumentor\Reflection\Types\Float_;

class CalculPriceMenuService implements ICalculPriceMenuService
{

    public function __construct()
    {
    }
    public function PriceMenu(Menu $data): float
    {

        $prix = 0;
        foreach ($data->getMenuBurgers() as $burger) {
            $menu = $burger->getBurger();
            $prix += $menu->getPrix() * $burger->getQuantite();
        }
        foreach ($data->getMenutailles() as $taille) {

            $prix += $taille->getTaille()->getPrix() * $taille->getQuantiteBoisson();
        }
        foreach ($data->getMenuPortions() as $portion) {
            $prix += $portion->getPortionFrite()->getPrix() * $portion->getQuantitePortion();
        }
        return $prix;
    }
}
