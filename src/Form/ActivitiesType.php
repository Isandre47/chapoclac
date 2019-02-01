<?php

namespace App\Form;

use App\Entity\Activities;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class ActivitiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cours', TextType::class, [

                'attr' => [
                    'class'=> 'input100',
                    'placeholder' => 'Intitulé'
                ],
                'constraints' => new NotBlank([
                    'message' => 'C\'est quoi son petit nom?'
                ]),
                'label' => 'Intitulé :',
            ])

            ->add('day', ChoiceType::class, array(
                'choices'=> array(
                    'Lundi'=>'Lundi',
                    'Mardi'=>'Mardi',
                    'Mercredi'=>'Mercredi',
                    'Jeudi'=>'Jeudi',
                    'Vendredi'=>'Vendredi',
                    'Samedi'=>'Samedi',
                    'Dimanche'=>'Dimanche'
                ),
                'label' => 'Jour du cours :',
                'placeholder'=>'Quel jour?'
            ))
            ->add('reservation')
            ->add('hour', TextType::class, array(
                'attr' => array(
                    'class'=> 'input100',
                    'placeholder' => 'Horaire. Ex : 14h-15h'
                ),
                'label' => 'Heure du cours : '
            ))

            ->add('price',IntegerType::class , array(
                'attr' => array(
                    'class' => 'imput100',
                    'placeholder' => 'Prix',
                )
            ))

            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                $poster=$event->getData()->getPicture();
                $form = $event->getForm();
                $form->add('picture', FileType::class, array(
                    'data_class' => null,
                    'attr' => array(
                        'class'=> ""
                    ),
                    'label' => 'Vous souhaitez changer la photo?',
                    'required' => false,
                    'constraints' => empty($poster) ?
                        [new Assert\NotBlank()] :
                        []
                ));

            })
//            ->add('users')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Activities::class,
        ]);
    }
}
