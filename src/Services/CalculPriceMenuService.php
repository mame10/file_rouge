<?php

namespace App\Services;

use App\Entity\Menu;


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
            $prix += $taille->getTailles()->getPrix() * $taille->getQuantiteBoisson();
        }
        foreach ($data->getMenuPortions() as $portion) {
            $prix += $portion->getPortionFrites()->getPrix() * $portion->getQuantitePortion();
        }
        return $prix;
    }
}
