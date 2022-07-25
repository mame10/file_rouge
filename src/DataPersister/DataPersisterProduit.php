<?php
namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Produit;
use App\Services\CalculPriceMenu;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Security;

class DataPersisterProduit implements DataPersisterInterface
{
    private $entityManager;
    private $pricemenu;
    private $security;

    public function __construct(Security $security, CalculPriceMenu $pricemenu, EntityManagerInterface $entityManager) 
    {
        $this->entityManager = $entityManager;
        $this->pricemenu = $pricemenu;
        $this->security = $security;   
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Produit ;
    }

    /**
     * @param User $data
     */
    public function persist($data, array $context = [])
    {
        if( $data instanceof Produit){
        $data->setUser($this->security->getUser()) ;
        }

        if($data instanceof Menu){
            $this->pricemenu->PriceMenu($data);
        }

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }

}