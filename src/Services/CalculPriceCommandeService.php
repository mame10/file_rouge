<?php
namespace App\Services;

use App\Entity\Commande;

class CalculPriceCommandeService implements ICalculPriceCommandeService
{
    public function __construct()
    {

    }

    public function PriceCommande(Commande $data): float
    {
        // dd($data)
        $prix =$data->getZone()->getPrix();
        foreach ($data->getBurgerCommandes() as $burger) {
            $cmd = $burger->getBurger();
            $prix += $cmd->getPrix() * $burger->getQuantity();
        }
        foreach ($data->getMenuCommandes() as $menu) {
            $prix += $menu->getMenus()->getPrix() * $menu->getQuantite();
        }
        foreach ($data->getPortionCommandes() as $portion) {
            $prix += $portion->getPortions()->getPrix() * $portion->getQuantite();
        }
        foreach ($data->getCommandeTailleBoissons() as $boisson) {
            $prix += $boisson->getTailleBoisson()->getTaille()->getPrix() * $boisson->getQuantiteCommande();
            // dd($prix);
        }
        return $prix;
    }
}