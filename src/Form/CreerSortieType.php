<?php

namespace App\Form;

use App\Entity\Sortie;
use App\Entity\Lieu;
use phpDocumentor\Reflection\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;



class CreerSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                "attr" => [
                    'class' => "form-control form-theme"
                ]
            ])
            ->add('dateHeureDebut', DateTimeType::class, ['widget'=>'single_text', "attr" => [
                'class' => "form-date form-theme"],
                'model_timezone' => 'Europe/Paris',
                'view_timezone' => 'Europe/Paris'
            ])
            ->add('duree', IntegerType::class,[
                "attr" => [
                    'class' => "form-control form-theme"
                ]
            ])
            ->add('dateLimiteInscription', DateTimeType::class, ['widget'=>'single_text',
                 "attr" => [
                    'class' => "form-date form-theme"],
                'model_timezone' => 'Europe/Paris',
                'view_timezone' => 'Europe/Paris'
            ])
            ->add('nbInscriptionMax', IntegerType::class,[
                "attr" => [
                    'class' => "form-control form-theme"
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description :',

                "attr" => [
                    "class" => "form-control form-theme"
                ]
            ] )
            ->add('lieu')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
