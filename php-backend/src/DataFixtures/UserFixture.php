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
        $user1 = new User();
        $user1->setIsActive(true);
        $user1->setRole("ROLE_ADMIN");
        $user1->setUsername("admin");
        $password1 = $this->encoder->encodePassword($user1, 'admin');
        $user1->setPassword($password1);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setIsActive(true);
        $user2->setRole("ROLE_MANAGER");
        $user2->setUsername("manager");
        $password2 = $this->encoder->encodePassword($user2, 'manager');
        $user2->setPassword($password2);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setIsActive(true);
        $user3->setRole("ROLE_USER");
        $user3->setUsername("user");
        $password3 = $this->encoder->encodePassword($user3, 'user');
        $user3->setPassword($password3);
        $manager->persist($user3);

        $user4 = new User();
        $user4->setIsActive(false);
        $user4->setRole("ROLE_ADMIN");
        $user4->setUsername("xvanic09");
        $user4->setName("Jozef");
        $user4->setSurname("Vanický");
        $password4 = $this->encoder->encodePassword($user4, 'asdf123');
        $user4->setPassword($password4);
        $manager->persist($user4);

        $user5 = new User();
        $user5->setIsActive(true);
        $user5->setRole("ROLE_ADMIN");
        $user5->setUsername("xwitas00");
        $user5->setName("Pavel");
        $user5->setSurname("Witassek");
        $password5 = $this->encoder->encodePassword($user5, 'zxcv321');
        $user5->setPassword($password5);
        $manager->persist($user5);

        unset($user1);
        unset($user2);
        unset($user3);
        unset($user4);
        unset($user5);

        $manager->flush();
        $manager->clear();
    }
}
