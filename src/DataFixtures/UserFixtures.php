<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
private UserPasswordHasherInterface $passwordHasher;
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
       $this->passwordHasher=$passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user=new User();
        $user->setLogin('client@gmail.com');
        $user->setNom('Mame');
        $user->setPrenom('Mounina');

        $hashedPassword = $this->passwordHasher->hashPassword(
        $user,
        'passer'
        );
        $user->setPassword($hashedPassword);
        $user->setRoles(['ROLE_CLIENT']);

        $user1=new User();
        $user1->setLogin('gestionnaire@gmail.com');
        $user1->setNom('fall');
        $user1->setPrenom('Mounina');
        $hashedPassword = $this->passwordHasher->hashPassword(
        $user1,
        'passer'
        );
        $user1->setPassword($hashedPassword);
        $user1->setRoles(['ROLE_GESTIONNAIRE']);
        $manager->persist($user);
        $manager->persist($user1);
        $manager->flush();
    }
}
