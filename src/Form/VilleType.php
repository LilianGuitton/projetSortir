<?php

namespace App\Form;

use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'label' => "Nom : ",
                "attr" => [
                    'style' => "border-radius: 20px;margin-left:12.5%;"
                ]
            ])
            ->add('codePostal',TextType::class,[
        'label' => "Code Postal : ",
                "attr" => [
                    'style' => "border-radius: 20px;margin-top: 3%;margin-bottom:3%;"
                ]
    ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,
        ]);
    }
}
