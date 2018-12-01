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
        $user4->setUsername("lukcikj");
        $user4->setName("Jan");
        $user4->setSurname("Lukčík");
        $password4 = $this->encoder->encodePassword($user4, 'asdf123');
        $user4->setPassword($password4);
        $manager->persist($user4);

        $user5 = new User();
        $user5->setIsActive(true);
        $user5->setRole("ROLE_ADMIN");
        $user5->setUsername("sirotnakt");
        $user5->setName("Tobiáš");
        $user5->setSurname("Sirotňák");
        $password5 = $this->encoder->encodePassword($user5, 'zxcv321');
        $user5->setPassword($password5);
        $manager->persist($user5);

        $user6 = new User();
        $user6->setIsActive(true);
        $user6->setRole("ROLE_MANAGER");
        $user6->setUsername("veselinyp");
        $user6->setName("Peter");
        $user6->setSurname("Vešelíny");
        $password6 = $this->encoder->encodePassword($user6, 'qwertyuiop789');
        $user6->setPassword($password6);
        $manager->persist($user6);

        $user7 = new User();
        $user7->setIsActive(true);
        $user7->setRole("ROLE_MANAGER");
        $user7->setUsername("adamekj");
        $user7->setName("Josef");
        $user7->setSurname("Adámek");
        $password7 = $this->encoder->encodePassword($user7, 'ghjk456');
        $user7->setPassword($password7);
        $manager->persist($user7);

        $user8 = new User();
        $user8->setIsActive(false);
        $user8->setRole("ROLE_MANAGER");
        $user8->setUsername("danist");
        $user8->setName("Tomáš");
        $user8->setSurname("Daniš");
        $password8 = $this->encoder->encodePassword($user8, 'poiu010');
        $user8->setPassword($password8);
        $manager->persist($user8);

        $user9 = new User();
        $user9->setIsActive(true);
        $user9->setRole("ROLE_USER");
        $user9->setUsername("vajdal");
        $user9->setName("Lukáš");
        $user9->setSurname("Vajda");
        $password9 = $this->encoder->encodePassword($user9, '4456vbnm');
        $user9->setPassword($password9);
        $manager->persist($user9);

        $user10 = new User();
        $user10->setIsActive(true);
        $user10->setRole("ROLE_USER");
        $user10->setUsername("dikejovan");
        $user10->setName("Nikola");
        $user10->setSurname("Dikejová");
        $password10 = $this->encoder->encodePassword($user10, 'ilovemylifelol1');
        $user10->setPassword($password10);
        $manager->persist($user10);

        $user11 = new User();
        $user11->setIsActive(true);
        $user11->setRole("ROLE_USER");
        $user11->setUsername("omachtm");
        $user11->setName("Martin");
        $user11->setSurname("Omacht");
        $password11 = $this->encoder->encodePassword($user11, 'proudgeek321');
        $user11->setPassword($password11);
        $manager->persist($user11);

        $user12 = new User();
        $user12->setIsActive(false);
        $user12->setRole("ROLE_USER");
        $user12->setUsername("kazikovak");
        $user12->setName("Kristína");
        $user12->setSurname("Kazíková");
        $password12 = $this->encoder->encodePassword($user12, 'ilovebiebermucq979');
        $user12->setPassword($password12);
        $manager->persist($user12);

        $user13 = new User();
        $user13->setIsActive(false);
        $user13->setRole("ROLE_ADMIN");
        $user13->setUsername("sevcb");
        $user13->setName("Branislav");
        $user13->setSurname("Ševc");
        $password13 = $this->encoder->encodePassword($user13, '565656jkjkjl');
        $user13->setPassword($password13);
        $manager->persist($user13);

        $manager->flush();
    }
}
