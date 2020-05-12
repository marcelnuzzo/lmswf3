<?php

namespace App\Controller;
//require '/vendor/autoload.php';

use App\Entity\Qcm;
use App\Entity\User;
use App\Form\QcmType;
use App\Entity\Answer;
use App\Form\QuizType;
use App\Form\Quiz2Type;
use App\Form\Quiz3Type;
use App\Repository\QcmRepository;
use App\Repository\UserRepository;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Node\RenderBlockNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;


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
        
        /*
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Hello World !');
        $writer = new Xlsx($spreadsheet);         
        $writer->save('C:\\wamp64\www\bonjour.xlsx');
        */

        /*
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load("C:\\wamp64\www\bonjour.xlsx");
        $sheet = $spreadsheet->getActiveSheet();
        $x= $sheet->getCell('A1')->getValue();
        */
        
        $question = $questionRepo->find(1)->getId(); 
        $answer = new Answer();
        $form = $this->createForm(Quiz3Type::class, $answer);
        $form->handleRequest($request);

        $count = 0;
        $user = $this->getUser()->getId();               
        $user = $userRepo->find($user);
        $toto = $user->getOkquiz();
        if($form->isSubmitted() && $form->isValid()) {
            
            $correction = $repo->findByCorrection($question);
            $correction = $correction[0]->getId();
            
            $idProposition = $answer->getProposition();
            
            if($correction == $idProposition){
                
                $user->setOkquiz(true);
                $manager->persist($user);
                $manager->flush();
                $count++;  
                $this->addFlash(
                    'success',
                    "Vous avez une bonne réponse"
                );
            } else {
                $this->addFlash(
                    'danger',
                    "Mauvaise réponse !"
                );
            }
            
            //return $this->redirectToRoute('answer_index');
        }

        return $this->render('home/userQuiz.html.twig', [
            'form' => $form->createView(),
            'count' => $count,
            'toto' => $toto
            //'user' => $user->getOkquiz(),
        ]);
    }
}
