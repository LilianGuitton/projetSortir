<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use App\Entity\Campus;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo',
                'attr'=>  ["class" => "form-control form-theme"]
            ])
            ->add('nom',TextType::class, [
                'label' => 'nom',
                'attr'=>  ["class" => "form-control form-theme"]
            ])
            ->add('prenom',TextType::class, [
                'label' => 'Prenom',
                'attr'=>  ["class" => "form-control form-theme"]
            ])
            ->add('email',EmailType::class, [
                'label' => 'email',
                'attr'=>  ["class" => "form-control form-theme"]
            ])
            ->add('telephone',TextType::class, [
                'label' => 'Téléphone',
                'attr'=>  ["class" => "form-control form-theme"]
            ])
            ->add('estRattacherA',EntityType::class, [
                "class" => Campus::class,
                "attr" => ["class" => "form-control form-theme"
                ]
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password','class' => 'form-control form-theme' ],

                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
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
