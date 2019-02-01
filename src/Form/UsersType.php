<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;

class UsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ],

            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            
            ->add('picture', FileType::class, [
                'data_class' => null,
                'required' => false
            ])

            ->add('pictureFun', FileType::class, [
                'data_class' => null,
                'label' => 'Une belle grimace ?!',
                'required' => false
            ])


            ->add('userAdress', TextType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('phoneHouse',TelType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ],
                "required" => false,
            ])
            ->add('phoneMobil',TelType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ]
            ])

            ->add('newsletters', HiddenType::class, [
                'data' => 'Oui'
            ])

            ->add('contributions', ChoiceType::class,[
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ],

            ])

            ->add('birthDate', BirthdayType::class, [
                'attr' => [
                    'class' => 'form-control-label'
                ],
            ])
            ->add('insurance',TextType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('numInsurance',TextType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('numberCheck', NumberType::class,[
                'attr' => [
                    'class' => 'form-control-label',
                ],
                'required' => false
            ])
            ->add('doctorName',TextType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('doctorPhone',TelType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ]
            ])
            ->add('doctorAdress',TextType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ]
            ])

            ->add('minorPhone', TelType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ],
                "required" => false,
                'constraints' => [new Assert\NotBlank()]
            ])
            ->add('minorClass', TextType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ],
                "required" => false,
                'constraints' => [new Assert\NotBlank()]
            ])
            ->add('minorNameResponsable', TextType::class, [
                'attr' => [
                    'class' => 'form-control-label',
                ],
                "required" => false,
                'constraints' => [new Assert\NotBlank()]
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                    'Bureau Président' => 'President',
                    'Bureau Président adjoint' => 'President adjoint',
                    'Bureau Secrétaire' => 'Secretaire',
                    'Bureau Secrétaire adjoint' => 'Secretaire adjoint',
                    'Bureau Trésorier' => 'Tresorier',
                    'Bureau Trésorier adjoint' => 'Tresorier adjoint',
                ],
                'label' => 'Quel rôle?',
                'expanded'  => true,
                'multiple' => true,
            ])
            ->add('newsletters', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'oui',
                    'Non' => 'non'
                ]
            ])

            ->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {

                $user = $event->getdata();
                $form = $event->getform();
                $date1 = new \DateTime();
                $date2 = $user->getBirthDate();

                $diff = $date1->diff($date2);
                $year = $diff->format("%Y");

                if ($year > 18) {


                    $form
                        ->remove('minorPhone')
                        ->remove('minorClass')
                        ->remove('minorNameResponsable');
                }

            });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
