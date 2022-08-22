<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreerSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut')
            ->add('duree')
            ->add('dateLimiteInscription')
            ->add('nbInscriptionMax')
            ->add('lieu')
            ->add('etat')
            ->add('campus')
            ->add('organisateur')
            ->add('participants')
            ->add('enregistrer', SubmitType::class, ['label' => "Enregistrer"])
            ->add('publier la sortie', SubmitType::class, ['label' => "Publier la sortie"])
            ->add('annuler', SubmitType::class, ['label' => "Annuler"])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
