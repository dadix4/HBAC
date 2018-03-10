<?php

namespace App\Form\Core;

use App\Entity\Core\Jour;
use App\Entity\Core\Licencie;
use App\Entity\Core\Saison;
use App\Entity\Core\Salle;
use App\Entity\Equipe\Equipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrainementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('jourEntrainement', EntityType::class, array(
                'class'    => Jour::class,
                'choice_label' => 'jour',
                'multiple' => false,
                'expanded' => false,
            ))
            ->add('horaireDebut', TimeType::class)
            ->add('horaireFin', TimeType::class)
            ->add('encadrants', EntityType::class, array(
                'class'    => Licencie::class,
                'choice_label' => 'getPrenomNom',
                'multiple' => true,
                'expanded' => false,
                'required'  => false,
                'attr' => array(
                    'class'=>'selectpicker',
                    'data-live-search' => 'true',
                    'title' => "Selectionner les encadrants",
                    'data-size' => "5",)
            ))
            ->add('equipes', EntityType::class, array(
                'class'    => Equipe::class,
                'choice_label' => 'nomEquipe',
                'multiple' => true,
                'expanded' => false,
                'required'  => false,
                'attr' => array(
                    'class'=>'selectpicker',
                    'title' => "Selectionner les équipes",
                    'data-size' => "10"),
            ))
            ->add('salle', EntityType::class, array(
                'class'    => Salle::class,
                'choice_label' => 'nomSalle',
                'multiple' => false,
                'expanded' => false,
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Core\Entrainement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_core_entrainement';
    }


}
