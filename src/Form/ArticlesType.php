<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\CategoryArticle;
use App\Entity\Users;
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


class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => [
                    'class' => 'input100',
                    'placeholder' => 'Titre!'
                ],
                'label' => 'The Titre :'
            ])
            ->add('subTitle', TextType::class, [
                'attr' => [
                    'class' => 'input100',
                    'placeholder' => "Une phrase d'accroche"
                ],
                'label' => 'La phrase d\'accroche :'
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'class' => 'input100',
                    'placeholder' => 'Il était une fois...'
                ],
                'label' => 'Il était une fois... :'
            ])
//            ->add('medias', FileType::class, [
//                'data_class' => null,
//                'label' => 'Votre image d\'illustration'
//            ])
            ->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
                $medias = $event->getData()->getMedias();
                $form = $event->getForm();
                $form->add('medias', FileType::class, array(
                    'data_class' => null,
                    'attr' => array(
                        'class'=> ""
                    ),
                    'label' => 'Vous souhaitez changer la photo?',
                    'required' => false,
                    'constraints' => empty($medias) ?
                        [new Assert\NotBlank()] :
                        []
                ));

            })
            ->add('press', TextType::class, [
                'attr' => [
                    'class' => 'input100',
                    'placeholder' => 'Un lien vers un article de presse?',
                ],
                    'label' => 'Article de presse :',
                    'required' => false
            ])
            ->add('category', EntityType::class, [
                'class' => CategoryArticle::class,
                'choice_label' => 'name',
                'label' => 'Catégorie'
            ])
            ->add('author', EntityType::class, [
                'class' => Users::class,
                'choice_label' => 'first_name',
                'label' => 'Auteur'
            ]);
//            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
