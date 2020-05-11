<?php

namespace App\Form;

use App\Entity\Answer;
use App\Entity\Question;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Service;
use App\Service\formService;

class Quiz3Type extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
            
        $builder
            
            ->add('proposition', ChoiceType::class, [
                'choices' => [
                    '2 X 1 = 1' => '1',
                    '2 X 1 = 2' => '2',
                    '2 X 1 = 3' => '3'
                ],
                'expanded' => true,
                'multiple' =>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
        ]);
    }
}
