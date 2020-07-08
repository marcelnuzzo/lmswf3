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
   

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $question = $options['question'];
        $choices =  $options['tabPropo'] ;
       
            $builder
            ->add('questions', EntityType::class, [
                'class' => Question::class,
                'query_builder' => function(EntityRepository $er) use($question) {
                    return $er->createQueryBuilder('q')
                            ->andWhere('q.id = :id')
                            ->setParameter('id', $question);
                }, 
                'choice_label' => 'label'
            ])
            
            ->add('proposition', ChoiceType::class, [
                'choices' => [
                    $choices[0] => '1',
                    $choices[1] => '2',
                    $choices[2] => '3',
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
            'question' => null,
            'tabPropo' => null,
        ]);
    }

}
