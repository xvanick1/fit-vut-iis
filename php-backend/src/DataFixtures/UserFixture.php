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

        $user1 = new User();
        $user1->setIsActive(true);
        $user1->setRole("ROLE_ADMIN");
        $user1->setUsername("test");
        $password1 = $this->encoder->encodePassword($user, 'test');
        $user1->setPassword($password1);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setIsActive(true);
        $user2->setRole("ROLE_ADMIN");
        $user2->setUsername("test");
        $password2 = $this->encoder->encodePassword($user, 'test');
        $user2->setPassword($password2);
        $manager->persist($user2);

        $user3 = new User();
        $user3->setIsActive(true);
        $user3->setRole("ROLE_ADMIN");
        $user3->setUsername("pavel.witassek");
        $password3 = $this->encoder->encodePassword($user, 'admin');
        $user3->setPassword($password3);
        $manager->persist($user);

        $user4 = new User();
        $user4->setIsActive(true);
        $user4->setRole("ROLE_ADMIN");
        $user4->setUsername("pavel.witassek");
        $password4 = $this->encoder->encodePassword($user, 'admin');
        $user4->setPassword($password4);
        $manager->persist($user);

        $user5 = new User();
        $user5->setIsActive(true);
        $user5->setRole("ROLE_ADMIN");
        $user5->setUsername("pavel.witassek");
        $password5 = $this->encoder->encodePassword($user, 'admin');
        $user5->setPassword($password5);
        $manager->persist($user);

        $user6 = new User();
        $user6->setIsActive(true);
        $user6->setRole("ROLE_ADMIN");
        $user6->setUsername("pavel.witassek");
        $password6 = $this->encoder->encodePassword($user, 'admin');
        $user6->setPassword($password6);
        $manager->persist($user);

        $user7 = new User();
        $user7->setIsActive(true);
        $user7->setRole("ROLE_ADMIN");
        $user7->setUsername("pavel.witassek");
        $password7 = $this->encoder->encodePassword($user, 'admin');
        $user7->setPassword($password7);
        $manager->persist($user);

        $manager->flush();
    }
}
