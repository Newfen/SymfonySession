<?php

namespace App\Form;

use SessionHandler;
use App\Entity\Session;
use App\Entity\Programme;
use App\Entity\ModuleFormation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProgrammeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('duree', NumberType::class)
            ->add('session', EntityType::class, [
                'class' => Session::class,
                'choice_label' => 'libelle_session'

            ])

            ->add('module', EntityType::class, [
                'class' => ModuleFormation::class,
                'choice_label' => 'libelle_module'

            ])
            ->add('valider', SubmitType::class);


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Programme::class,
        ]);
    }
}
