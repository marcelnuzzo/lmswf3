<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Entity\Response;
use App\Entity\Role;
use App\Entity\User;
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
        $adminRole = new Role();
        $adminRole->setTitle('ROLE_ADMIN');
        $manager->persist($adminRole);
        
        $users = [];
        $adminUser = new User();
        $adminUser->setFirstname("Marcel")
                ->setLastname("Nuzzo")
                ->setBirthAt(new \DateTime())
                ->setPhone("0618512746")
                ->setPicture('https://lh3.googleusercontent.com/a-/AOh14Giy3pomEF4DFzKVvYb03_ATPsjRYypTILMxlnD_=s60-cc-rg')
                ->setEmail("nuzzo.marcel@aliceadsl.fr")
                ->setHash($this->encoder->encodePassword($adminUser, '1234'))
                ->setOkquiz(false)
                ->addUserRole($adminRole);
       
        $manager->persist($adminUser);
        $users[] = $adminUser;

     /*
        $k=2;
        $num=0;
        for($i=1; $i<=5; $i++) {
            $question = new Question();
           
            $question->setLabel('conbien font'. $k .'fois'. $i);
            $manager->persist($question);

            $num = $i;
            $correction = true;
            for($j=1; $j<=3; $j++) {
                
                $response = new Response();
                $response->setProposition($num)
                         ->setCorrection($correction)
                         ->setQuestions($question);

                $manager->persist($response);
                $num++;
            }
        }
        */
        
        
        
        $manager->flush();


    }
}
