<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    public const USER = [
        'quentin.adadain@gmail.com' => [
            'roles' => ['ROLE_ADMIN'],
            'firstName' => 'Quentin',
            'lastName' => 'Adadain',
            'pseudo' => 'Rolls',
            'password' => 'test'
        ],
        'test@gmail.com' => [
            'roles' => ['ROLE_ADMIN'],
            'firstName' => 'test',
            'lastName' => 'test',
            'pseudo' => 'test',
            'password' => 'test'
        ],
        'test@gmail.com' => [
            'roles' => ['ROLE_ADMIN'],
            'firstName' => 'test',
            'lastName' => 'test',
            'pseudo' => 'test',
            'password' => 'test'

        ]

    ];


    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::USER as $email => $data) {
            $user = new User();
            $user->setEmail($email)
                ->setRoles($data['roles'])
                ->setFirstName($data['firstName'])
                ->setLastName($data['lastName'])
                ->setPseudo($data['pseudo'])
                ->setPassword($this->passwordEncoder->encodePassword($user, $data['password']));

            $manager->persist($user);
        }
        $manager->flush();
    }
}
