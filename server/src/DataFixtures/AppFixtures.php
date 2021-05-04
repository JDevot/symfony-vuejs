<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $post = new Post();
            $post->setTitle('title '.$i);
            $post->setBody('body '.$i);
            $manager->persist($post);
        }

        // $product = new Product();
        // $manager->persist($product);
        
        $manager->flush();
    }

}
