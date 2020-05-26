<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $user = new User();
        $user->setUsername('zozor')
            ->setEmail('zozor@zozor.fr')
            ->setPassword('1234567');
        
        $manager->persist($user);
                
        $category = new Category();
        $category->setTitle('Category A')
                 ->setDescription('Lorem Ipsum A');
        $manager->persist($category);

        $article = new Article();
        $article->setTitle("Article A")
                ->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            Sed iaculis tempor mi ut ullamcorper. Sed tincidunt gravida nibh, 
                            vel hendrerit mauris eleifend vitae. Ut id consectetur mauris. 
                            Nullam tempus elit et malesuada volutpat.")
                ->setImage("http://placehold.it/350x150")
                ->setCreatedAt(new \DateTime())
                ->setCategory($category)
                ->setUser($user);
        $manager->persist($article);

        $comment = new Comment();
        $comment->setArticle($article)
                ->setContent("Lorem ipsum dolor sit amet, consectetur adipiscing elit. 
                            Sed iaculis tempor mi ut ullamcorper.")
                ->setCreatedAt(new \DateTime());

        $manager->persist($comment);

        $manager->flush();
    }
}
