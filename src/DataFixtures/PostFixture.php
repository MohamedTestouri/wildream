<?php

namespace App\DataFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Post;
use Doctrine\Persistence\ObjectManager;

class PostFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $post = new Post();

        $manager->persist($post);

        $manager->flush();
    }
}
