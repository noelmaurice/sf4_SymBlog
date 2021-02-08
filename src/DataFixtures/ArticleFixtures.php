<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $faker = Faker\Factory::create('fr_FR');
        // faker repository and documentation : https://github.com/fzaninotto/Faker

        for ($i = 1; $i <= 3; $i++)
        {
            $category = new Category();

            $category->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());

            $manager->persist($category);

            for ($j = 1; $j <= mt_rand(4, 6); $j++) {
                $article = new Article();

                $content = "<p>" . join($faker->paragraphs(5), "</p><p>") . "</p>";

                $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage("http://via.placeholder.com/350x150")
                    // ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween("-6 months"))
                    ->setCategory($category);

                $manager->persist($article);

                for ($k = 1; $k <= mt_rand(4, 10); $k++) {
                    $comment = new Comment();

                    $content = "<p>" . join($faker->paragraphs(2), "</p><p>") . "</p>";

                    $days = (new \DateTime())->diff($article->getCreatedAt())->days;

                    $comment->setAuthor($faker->name())
                        ->setContent($content)
                        ->setCreatedDate($faker->dateTimeBetween("-" . $days . " days"))
                        ->setArticle($article);

                    $manager->persist($comment);
                }
            }
        }

        $manager->flush();
    }
}
