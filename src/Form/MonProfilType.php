<?php

namespace App\Form;

use App\Entity\Participant;
use Doctrine\DBAL\Types\StringType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
                    "class" => "form-control"
                ]
            ])
            ->add('prenom', TextType::class, [
        "attr" => [
            "class" => "form-control"
          ]
       ])
            ->add('nom', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])

            ->add('telephone',TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('email', EmailType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'les mots de passe doivent être identique.',
                'options' => ['attr' => ['class' => 'form-control']],
                'required' => true,
                'first_options'  => ['label' => 'Password'],
                'second_options' => ['label' => 'Repeat Password'],

            ])
            ->add('estRattacherA',TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('photo', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
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
