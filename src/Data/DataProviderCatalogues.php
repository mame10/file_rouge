<?php
namespace App\DataProvider;

use App\Entity\Catologues;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class DataProviderCatalogues implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{

    public function __construct(BurgerRepository $burger,MenuRepository $menu)
    {
       $this->burger=$burger;
       $this->menu=$menu; 
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Catologues::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        if(Catologues::class === $resourceClass){
            return [
                ["menu"=>$this->menu->findAll()],
                ["burger"=>$this->burger->findAll()]
            ];
        } 
    }
}