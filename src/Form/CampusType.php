<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CampusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => 'Nom :',
                "attr" =>['class'=> 'form-theme',
                    'style' => "margin-bottom:3%; margin-left :1%;"
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Campus::class,[
                'attr' => ['class' => 'btn-wide btn-normal',
                    'style' => 'margin-top:3%;margin-bottom:3%; ',],


                ]
        ]);
    }
}
