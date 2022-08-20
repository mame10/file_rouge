<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Entity\Produit;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\ICalculPriceMenuService;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class DataPersisterProduit implements DataPersisterInterface
{
    private $entityManager;
    private $security;

    private ICalculPriceMenuService $pricemenu;
    // private $security;
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage, Security $security, ICalculPriceMenuService $pricemenu, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->pricemenu = $pricemenu;
        $this->security = $security;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Produit;
    }

   /**
     * @param Produit $data
     */
    public function persist($data, array $context = [])
    {

        if ($data instanceof Produit) {
            if ($data->getImageFile()) {
                $data->setImage(file_get_contents($data->getImageFile()));
            }
        }
        if ($data instanceof Produit) {
            $data->setGestionnaire($this->tokenStorage->getToken()->getUser());
            // $data->setGestionnaire($this->security->getUser())
        }

        if ($data instanceof Menu) {
            $prix = $this->pricemenu->PriceMenu($data);
            $data->setPrix($prix);
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
