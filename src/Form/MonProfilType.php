<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Doctrine\DBAL\Types\StringType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MonProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('pseudo', TextType::class, [
                "attr" => [
                    "class" => "form-control form-theme"
                ]
            ])
            ->add('prenom', TextType::class, [
        "attr" => [
            "class" => "form-control form-theme"
          ]
       ])
            ->add('nom', TextType::class, [
                "attr" => [
                    "class" => "form-control form-theme"
                ]
            ])

            ->add('telephone',TextType::class, [
                "attr" => [
                    "class" => "form-control form-theme"
                ]
            ])
            ->add('email', EmailType::class, [
                "attr" => [
                    "class" => "form-control form-theme"
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'les mots de passe doivent être identique.',
                'options' => ['attr' => ['class' => 'form-control form-theme']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password']

            ])
            ->add('estRattacherA',EntityType::class, [
                "class" => Campus::class,
                "attr" => [
                    "class" => "form-control form-theme"
                ]
            ])
            ->add('photo', TextType::class, [
                "attr" => [

                    "class" => "form-control form-theme"
                ],
                'required' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
