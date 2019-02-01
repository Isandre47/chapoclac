<?php

namespace App\DataFixtures;

use App\Entity\Articles;
use App\Entity\CategoryArticle;
use App\Entity\Gallery;
use App\Entity\Spectacles;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;


class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($i = 1; $i <=100; $i++){
            $user = new Users();
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $user->setUserAdress($faker->address);
            $user->setPhoneHouse($faker->phoneNumber);
            $user->setPhoneMobil($faker->phoneNumber);
            $user->setContributions("oui");
            $user->setNewsletters("oui");
            $user->setCreateDate(new \DateTime('now'));
            $user->setBirthDate($faker->dateTime());
            $user->setInsurance($faker->sentence);
            $user->setNumInsurance($faker->phoneNumber);
            $user->setNumberCheck($faker->phoneNumber);
            $user->setDoctorName($faker->firstName);
            $user->setDoctorPhone($faker->phoneNumber);
            $user->setDoctorAdress($faker->address);
            $user->setMinorPhone($faker->phoneNumber);
            $user->setMinorClass($faker->sentence);
            $user->setMinorNameResponsable($faker->name);
            $user->setStatus("[\"ROLE_USER\"]");
            $user->setPicture('http://cdn.osxdaily.com/wp-content/uploads/2014/07/users-and-groups-icon-mac.png');
            $user->setEmail($faker->email);
            $user->setRoles(["ROLE_ADMIN"]);
            $user->setPassword($faker->password);

            $manager->persist($user);

        }

        $category1 = new CategoryArticle();
        $category1->setName('Chapo-Clac');
        $manager->persist($category1);
        $this->addReference('Chapo-Clac', $category1);

        $category2 = new CategoryArticle();
        $category2->setName('amis');
        $manager->persist($category2);
        $this->addReference('amis', $category2);

        for($i = 1; $i <= 25; $i++){
            $article = new Articles();
            $article->setAuthor($user);
            $article->setTitle($faker->title);
            $article->setContent($faker->paragraph);
            $article->setMedias($faker->imageUrl('300'));
            $article->setPress($faker->text(200));
            $article->setSubTitle($faker->text(150));
            $article->setCategory($this->getReference('Chapo-Clac'));

            $manager->persist($article);
        }

        for($i = 26; $i <= 50; $i++){
            $article = new Articles();
            $article->setAuthor($user);
            $article->setTitle($faker->title);
            $article->setContent($faker->paragraph);
            $article->setMedias('https://placehold.it/350x1350');
            $article->setMedias($faker->imageUrl('300'));
            $article->setPress($faker->text(200));
            $article->setSubTitle($faker->text(150));
            $article->setCategory($this->getReference('amis'));

            $manager->persist($article);
        }

        $spectacle1 = new Spectacles();
        $spectacle1->setTitle('pizza');
        $spectacle1->setPoster('8cb9d8edf3c944f17591c07a7636af21.jpeg');
        $spectacle1->setResume('spectacle about pizza');
        $manager->persist($spectacle1);
        $this->addReference('pizza', $spectacle1);

        $gallery1 = new Gallery();
        $gallery1->setSpectacle($this->getReference('pizza'));
        $gallery1->setPicture('2011-06-25.jpg');
        $manager->persist($gallery1);

        $manager->flush();
    }
}
