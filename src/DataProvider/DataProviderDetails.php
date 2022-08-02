<?php
namespace App\DataProvider;


use App\Entity\DTO\Details;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use App\Repository\BoissonRepository;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;

class DataProviderDetails implements ItemDataProviderInterface,RestrictedDataProviderInterface
{
    private $burgers;
    private $menus;
    private $portions;
    private $boissons;
    public function __construct(BurgerRepository $burger,MenuRepository $menu,BoissonRepository $boisson,PortionFriteRepository $portion)
    {
       $this->burgers=$burger;
       $this->menus=$menu;
       $this->boissons=$boisson; 
       $this->portions=$portion; 
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Details::class === $resourceClass;
    }

    public function getItem(string $resourceClass,$id,string $operationName = null, array $context = []): ?Details
    {
        $detailsProduit= new Details();
        $detailsProduit->id = $id;
        $detailsProduit->burger = $this->burgers->find($id);
        $detailsProduit->menu = $this->menus->find($id);
        $detailsProduit->boissons = $this->boissons->findAll(['isEtat'=> true]);
        $detailsProduit->portions= $this->portions->findAll(['isEtat'=> true]);
        return $detailsProduit;
        // $detailsProduit->id = $id;
        // ($this-> menus->findOneBy(['id' => $id, 'isEtat'=>true]) !=null)?
        // $detailsProduit->burger = $this->burgers->findOneBy(['id' => $id, 'isEtat'=> true]):
        // $detailsProduit->boisson = $this->boissons->findBy(['isEtat'=> true]);
        // $detailsProduit->portion= $this->portions->findBy(['isEtat'=> true]);
    }
}
