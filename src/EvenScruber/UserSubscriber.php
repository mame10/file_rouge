<?php
namespace App\EventSubscriber;

use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserSubscriber implements EventSubscriberInterface
{
    private ?TokenInterface $token;
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage->getToken();

    }
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => [
                ['prePersist', 0]
            ]
            ];
    }

    private function getUser()
    {
        //dd($this->token);

        if (null === $token = $this->token) {
            return null;
        }
        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return null;
        }
        return $user;
    }
    public function prePersist()
    { 
       /*  ResponseEvent $event
       $produit = $event->getRequest()->get("data") ;
        if ($produit instanceof Burger) {
            $produit->setUser($this->getUser());
            
        } */
        // if ($args->getObject() instanceof Boisson) {
        //     $args->getObject()->setUser($this->getUser());
        // }
        // if ($args->getObject() instanceof PortionFrite) {
        //     $args->getObject()->setUser($this->getUser());
        // }
        // if ($args->getObject() instanceof Menu) {
        //     $args->getObject()->setUser($this->getUser());
        // }
        // if ($args->getObject() instanceof Taille) {
        //     $args->getObject()->setUser($this->getUser());
        // }

        
        // return $produit;
    }
}

