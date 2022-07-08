<?php
namespace App\Services;

use App\Entity\Menu;

interface ICalculPriceMenuService{

    public function PriceMenu(Menu $data):float;

}