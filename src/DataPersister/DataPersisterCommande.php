<?php
namespace App\DataPersister;

use App\Entity\Commande;
use Doctrine\ORM\EntityManagerInterface;
use App\Services\ICalculPriceCommandeService;
use Symfony\Component\Security\Core\Security;
use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


class DataPersisterCommande implements DataPersisterInterface
{
    private $entityManager;
    private $security;
    private ICalculPriceCommandeService $pricecommande;
    private TokenStorageInterface $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage, Security $security, ICalculPriceCommandeService $pricecmd, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->pricecommande = $pricecmd;
        $this->security = $security;
        $this->tokenStorage = $tokenStorage;
    }
    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commande;
    }

   /**
     * @param Commande $data
     */
    public function persist($data, array $context = [])
    { 
        if ($data instanceof Commande) {
            $data->setClient($this->tokenStorage->getToken()->getUser());
        }

        if ($data instanceof Commande) {
            $prix = $this->pricecommande->PriceCommande($data);
            $data->setMontant($prix);
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
