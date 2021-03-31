<?php

namespace App\DataFixtures;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Cocur\Slugify\Slugify;
use phpDocumentor\Reflection\Types\This;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $password){
        $this->passwordEncoder=$password;
    }
    public function load(ObjectManager $manager)
    {
        $this->loadUsers($manager);
        $this->loadPosts($manager);
    }
    public function loadPosts(ObjectManager $manager){
        $slugify= new Slugify();
        for ($i=0;$i<20;$i++){
            $post=new Post();
            $post->setTitle('this is my title number '.rand(0,100));
            $post->setBody('this is my body number '.rand(0,100));
            $post->setTime(new \DateTime());
            $post->setImage('this is my image '.rand(0,100));
            $post->setUser($this->getReference('chiheb'));
            $post->setBody($slugify->slugify($post->getTitle()));
            $manager->persist($post);
        }
        $manager->flush();

    }
    public function loadUsers(ObjectManager $manager){
            $user=new User();
            $user->setUsername('chiheb98');
            $user->setFullname('Chiheb Chikhaoui');
            $user->setEmail('chiheb@chiheb.com');
            $user->setPassword(
                $this->passwordEncoder->encodePassword($user,'chiheb123')
            );
            $this->addReference('chiheb',$user);
            $manager->persist($user);
            $manager->flush();
            
    }
}
