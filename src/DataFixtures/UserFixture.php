<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $passwordEncoder;

    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setEmail('admin@mail.com')
            ->setPassword($this->passwordEncoder->encodePassword($admin, 'password'))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);

        $manager->flush($admin);
    }


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
}
