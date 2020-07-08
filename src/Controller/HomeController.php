<?php

namespace App\Controller;
//require '/vendor/autoload.php';

use App\Service;
use App\Entity\User;
use App\Entity\Answer;
use App\Form\LoadType;
use App\Form\QuizType;
use App\Form\Quiz2Type;
use App\Form\Quiz3Type;
use App\Form\Quiz4Type;
use App\Entity\Question;
use App\Entity\Testquiz;
use App\Service\Readfile;
use App\Service\Writefile;
use App\Repository\QcmRepository;
use App\Repository\UserRepository;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use Symfony\Bridge\Twig\Node\RenderBlockNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/quiz", name="home_quiz")
     */
    public function quiz(AnswerRepository $answer)
    {      
        $answers = $this->getDoctrine()
        ->getRepository(Answer::class)
        ->findBy(['correction' => true]);
        return $this->render('home/quiz.html.twig', [
            'answers' => $answers
        ]);
    }
    

    /**
     * @Route("/quizUser", name="home_quizUser")
     */
    public function formQuiz(QuestionRepository $repo, Request $request, EntityManagerInterface $manager, AnswerRepository $qcms)
    {
        
        $form = $this->createForm(QuizType::class);
        $form2 = $this->createForm(Quiz2Type::class);
        $question1 = $repo->find(1);
        $question2 = $repo->find(2);
       
        return $this->render('home/quizUser.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
            'question1' => $question1,
            'question2' => $question2,
        ]);
    }

    /**
     * @Route("/userQuiz", name="home_userQuiz")
     */
    public function userQuiz(Request $request, EntityManagerInterface $manager, AnswerRepository $repo, QuestionRepository $questionRepo, UserRepository $userRepo)
    {
        $question = $questionRepo->findFirstId()[0]['id'];
        $id = $question;
        //dd($id);
        $tabPropo = [];
        for($i=0; $i<3; $i++) {
            $answers = $repo->findPropo($id)[$i];
            $answers = $answers['proposition'];
            $tabPropo[] = $answers;
        }
        
        //dd($toto);
        $answer = new Answer();
        $form = $this->createForm(Quiz4Type::class, $answer, [
            'question' => $question,
            'tabPropo' => $tabPropo,
        ]);
        $form->handleRequest($request);

        $count = 0;
        $user = $this->getUser()->getId(); 
                    
        $user = $userRepo->find($user);
        $ok = "";
        if($user->getOkquiz() != 0)
            $ok = true;
        else
            $ok = false;
        //$user = $user->getOkquiz();
        //dd($count); 
        if($form->isSubmitted() && $form->isValid()) {
            
            $correction = $repo->findByCorrection($question);       
            $correction = $correction[0]->getId();   
            $idProposition = $answer->getProposition();
           
            if($correction == $idProposition){
                $user->setOkquiz(true);
                //dd($user);
                $manager->persist($user);
                $manager->flush();
                $count++;  
                $this->addFlash(
                    'success',
                    "Vous avez une bonne réponse"
                );
                return $this->redirectToRoute('home_userQuiz');
            } else {
                $this->addFlash(
                    'danger',
                    "Mauvaise réponse !"
                );
            }
            
        }

        return $this->render('home/userQuiz2.html.twig', [
            'form' => $form->createView(),
            'count' => $count,
            'user' => $user,
            'ok' => $ok,
            'questions' => $questionRepo->findAll(),
        ]);
    }


    /**
     * @Route("load", name="testquiz_load")
     */
    public function loadform(Request $request, EntityManagerInterface $manager, Readfile $readfile) 
    {
        $form = $this->createForm(LoadType::class);
        $form->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid()) {
            $donnee = $form->getData();
            $fichier = $donnee['Chargement'];
            $getHighestRow1 = $readfile->getRead2($fichier)[0];
            $getHighestRow2 = $readfile->getRead2($fichier)[2];
            $valCell1 = $readfile->getRead2($fichier)[1];
            $valCell2 = $readfile->getRead2($fichier)[3];
            //$sheet = $readfile->getRead2($fichier);
            
                $ctr=0;
                for($i=1; $i<=$getHighestRow2; $i++) {
                    $question = new Question();
                    $question->setLabel($valCell2[$ctr]);
                    $ctr++;               
                    $manager->persist($question);
                }
                $manager->flush();

                $questionRepo = $manager->getRepository('App:Question');
                $ctr=0;
                $ctr2=1;
                for($i=1; $i<=$getHighestRow1; $i++) {
                    $answer = new Answer();
                    $answer->setQuestions($questionRepo->find($ctr2));
                    $ctr++;
                    $answer->setProposition($valCell1[$ctr]);
                    $ctr++;
                    $answer->setCorrection($valCell1[$ctr]);
                    $ctr++;                
                    $manager->persist($answer);
                    if($i == 3) {
                        $ctr2++;
                    }
                }
                $manager->flush();
                
            }
        
        return $this->render('testquiz/load.html.twig', [
            'form' => $form->createView(),
           
        ]);

    }

    /**
     * @Route("/home/raz", name="home_raz")
     */
    public function raz(UserRepository $userRepo, EntityManagerInterface $manager)
    {
        $user = $this->getUser()->getId();
        $user = $userRepo->find($user);
        $user->setOkquiz(false);
        $manager->persist($user);
        $manager->flush();
        
        //dd($user);
        return $this->redirectToRoute('homepage');
        
    }
}
