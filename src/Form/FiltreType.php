<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('campus', EntityType::class, ["class"=>Campus::class, "label"=>"Campus",
                'attr'=>['class'=> 'form-theme']
                ])
            ->add('nom', TextType::class, ["label"=>"Le nom de la sortie contient :",
                'attr'=> ['class'=>'form-theme']
            ])
            ->add('debut', DateType::class,["label"=>"Entre :"])
            ->add('fin', DateType::class, ["label"=> "et :"
                ])
            ->add('monOrga', CheckboxType::class, ["label"=> "Sorties dont je suis l'organisateur/trice"])
            ->add('inscrit', CheckboxType::class, ["label"=> "Sorties auxquelles je suis inscrit/e"])
            ->add('nonInscrit', CheckboxType::class, ["label"=> "Sorties auxquelles je ne suis pas inscrit/e"])
            ->add('passee', CheckboxType::class, ["label"=> "Sorties passées"])
            ->add('Rechercher', SubmitType::class,[
                'label' => 'Rechercher',
                'attr' => ['class' => 'btn-wide btn-normal' ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
