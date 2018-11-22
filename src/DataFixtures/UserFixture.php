<?php

namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setIsActive(true);
        $user->setRole("ROLE_ADMIN");
        $user->setUsername("pavel.witassek");
        $password = $this->encoder->encodePassword($user, 'admin');
        $user->setPassword($password);
        $manager->persist($user);

        $user2 = new User();
        $user2->setIsActive(true);
        $user2->setRole("ROLE_ADMIN");
        $user2->setUsername("test");
        $password2 = $this->encoder->encodePassword($user, 'test');
        $user2->setPassword($password2);
        $manager->persist($user2);

        $manager->flush();
    }
}
