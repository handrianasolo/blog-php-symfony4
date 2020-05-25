<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin->setPseudo("admin")
                ->setPassword("1234567");
        
        $manager->persist($admin);

        $manager->flush();
    }
}
