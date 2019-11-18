<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Website;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder; 

    public function __construct(UserPasswordEncoderInterface $encoder) {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $admin = new Admin();
        $admin->setEmail('contact@florentnicolas.com')
            ->setPassword($this->encoder->encodePassword($admin, 'toor'));
        $manager->persist($admin);
        

        $urls = ['https://florentnicolas.com', 'https://xiii.florentnicolas.com', 'https://stageb1.florentnicolas.com', 
        'https://stageb2.florentnicolas.com', 'https://donwdeb.fake.com', 'https://xiii.florentnicolas.com/test404'];
        $names = ['Florent NICOLAS', 'XIII Mystery', 'Stage B1', 'Stage B2', 'TestWebsite', 'Test404'];

        for($w = 0; $w <= 5; $w++) {
            $website = new Website();
            $website->setUrl($urls[$w])
                    ->setName($names[$w]);
            $manager->persist($website);
        }

        $manager->flush();
    }
}
