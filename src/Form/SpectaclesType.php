<?php

namespace App\Form;

use App\Entity\Spectacles;
use App\Entity\Users;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;


class SpectaclesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                $poster=$event->getData()->getPoster();
                $form = $event->getForm();
                $form->add('poster', FileType::class, array(
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
            ->add('title',TextType::class, array(
                'attr' => array(
                'class'=> 'input100',
                'placeholder' => 'Titre!',
            ),
                'label' => 'The Titre :'

                )
            )
            ->add('resume', TextareaType::class, array(
                'attr' => array(
                    'class' => 'input100',
                    'placeholder' => 'De quoi ça parle?'
                ),
                'label' => 'De quoi ça parle :'
            ))
            ->add('users', EntityType::class, array(
                'class'=> Users::class,

                // query builder basé sur exemple doc symfony, pour trier les utilisateurs affiché par ordre alphabetique

                'query_builder'=> function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('u')->orderBy('u.lastName', 'ASC');
                },
                'choice_label' => 'Fullname',
                'multiple' => true, 'expanded'=> true,
                'label' => 'Comédiens',
                'attr' => [
                    'class' => 'justify-content-between row ml-3 mr-1'
                ]
            ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Spectacles::class,
        ]);
    }
}
