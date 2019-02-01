<?php

namespace App\Form;

use App\Entity\Comments;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Exprime-toi !!!'
                ]
            ])
//            ->add('date')
            ->add('speudo', TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Ton pseudo ?'
                ]
            ])
//            ->add('author', TextType::class, [
//                'attr' => [
//                    'class' => 'input100',
//                    'placeholder' => 'Nom'
//                ]
//            ])
//            ->add('articles')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comments::class,
        ]);
    }
}
