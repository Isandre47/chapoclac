<?php
/**
 * Created by IntelliJ IDEA.
 * User: jefdc
 * Date: 2019-01-03
 * Time: 14:44
 */

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
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Tests\Extension\Core\Type\TextTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\NotBlank;


class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Prénom'
                ],

            ])
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Nom'
                ]
            ])
            ->add('userAdress', TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Adresse'
                ]
            ])
            ->add('phoneHouse',TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => "Tel fixe au format : 0456789876"
                ],
                "required" => false,
            ])
            ->add('phoneMobil',TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => "Portable au format : 0678654323"
                ]
            ])
            ->add('email',EmailType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Email'
                ]
            ])

            ->add('password', PasswordType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Password'
                ]
            ])
            ->add('confirmPassword', PasswordType::class, [
            ])
            ->add('newsletters', HiddenType::class, [
                'data' => 'Oui'
            ])

            ->add('birthDate', BirthdayType::class, [
                'attr' => [
                    'class' => 'input100'
                ],
//                'label' => 'Date de naissance'
            ])
            ->add('insurance',TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Assurance'
                ]
            ])
            ->add('numInsurance',TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Contrat Assurance'
                ]
            ])

            ->add('doctorName',TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Nom du médecin traitant'
                ]
            ])
            ->add('doctorPhone',TelType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => "Tél du médecin au format : 0456789876"
                ]
            ])
            ->add('doctorAdress',TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Adresse du docteur'
                ]
            ])

            ->add('minorPhone', TelType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => "Portable du Responsable légal au format : 0678654323"
                ],
                "required" => false,
                'constraints' => [new Assert\NotBlank()]
            ])
            ->add('minorClass', TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Quelle classe?'
                ],
                "required" => false,
                'constraints' => [new Assert\NotBlank()]
            ])
            ->add('minorNameResponsable', TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Responsable légal'
                ],
                "required" => false,
                'constraints' => [new Assert\NotBlank()]
            ])
            ->add('validate', TextType::class, [
                'attr' => [
                    'class' => 'input100',
//                    'placeholder' => 'Validate'
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

                    $form->add('minorPhone', TelType::class, [
                            'attr' => [
                                'class' => 'input100',
//                                'placeholder' => "Portable du Responsable légal au format : 0678654323"
                            ],
                            "required" => false,
                            'constraints' => [new Assert\NotBlank()]
                        ])
                        ->add('minorClass', TextType::class, [
                            'attr' => [
                                'class' => 'input100',
//                                'placeholder' => 'Quelle classe?'
                            ],
                            "required" => false,
                            'constraints' => [new Assert\NotBlank()]
                        ])
                        ->add('minorNameResponsable', TextType::class, [
                            'attr' => [
                                'class' => 'input100',
//                                'placeholder' => 'Responsable légal'
                            ],
                            "required" => false,
                            'constraints' => [new Assert\NotBlank()]
                        ]);
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