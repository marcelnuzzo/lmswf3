<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Question;
use App\Repository\AnswerRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class Quiz4Type extends AbstractType
{
    public function getProposition(AnswerRepository $repo)
    {
        $val1 = $repo->findProposition()[0]['proposition'];
        $val2 = $repo->findProposition()[1]['proposition'];
        $val3 = $repo->findProposition()[2]['proposition'];
        return [$val1, $val2, $val3];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('questions', EntityType::class, [
                'class' => Question::class,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('q')
                            ->andWhere('q.id = :id')
                            ->setParameter('id', 1);
                }, 
                'choice_label' => 'label'
            ])
            /*
            ->add('proposition', EntityType::class, [
                'class' => Answer::class, 
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                            ->andWhere('a.questions = :question')
                            ->setParameter('question', 1);
                },
                'choice_label' => 'proposition',
                'multiple' => false,
                'expanded' => true,
            ])
            */
            ->add('proposition', ChoiceType::class, [
                'choices' => [
                    '3 X 1 = 2' => '1',
                    '3 X 1 = 3' => '2',
                    '3 X 1 = 4' => '3'
                ],
                'expanded' => true,
                'multiple' =>false,
            ])
            
            //->add('correction')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }

}
