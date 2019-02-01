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
            ->setUsername('admin')
            ->setSalt('salt')
            ->setPassword($this->passwordEncoder->encodePassword($admin, 'password'))
            ->addRole(['ROLE_ADMIN']);

        $manager->persist($admin);

        $manager->flush($admin);

        $user = new User();

        $user->setEmail('user@mail.com')
            ->setUsername('user')
            ->setSalt('salt')
            ->setPassword($this->passwordEncoder->encodePassword($user, 'password'))
            ->addRole(['ROLE_USER']);

        $manager->persist($user);
        $manager->flush($user);
    }

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
}
