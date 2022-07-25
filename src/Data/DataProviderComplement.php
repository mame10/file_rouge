<?php
namespace App\DataProvider;

use App\Entity\Complements;
use App\Repository\TailleRepository;
use App\Repository\PortionFriteRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

class DataProviderComplement implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
{

    public function __construct(PortionFriteRepository $portions,TailleRepository $taille)
    {
       $this->portions=$portions;
       $this->taille=$taille; 
    }
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return Complements::class === $resourceClass;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = []): iterable
    {
        if(Complements::class === $resourceClass){
            return [
                ["frites"=>$this->portions->findAll()],
                ["tailles"=>$this->taille->findAll()]
            ];
        } 
    }
}