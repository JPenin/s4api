<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class AppFixtures
 *
 * @package App\DataFixtures
 */
class AppFixtures extends Fixture
{
    /**
     * Añade 5 usuarios con los siguientes emails : password
     * - test1@email.com  :  1234
     * - test2@email.com  :  1234
     * - test3@email.com  :  1234
     * - test4@email.com  :  1234
     * - test5@email.com  :  1234
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setEmail('test'.$i.'@mail.com');
            $user->setPassword('1234');
            $manager->persist($user);
        }

        $manager->flush();
    }
}
