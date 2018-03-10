<?php

namespace App\Form\Equipe;

use App\Entity\Equipe\RefCompetition;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RefCompetitionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('competition',ChoiceType::class, array(
                'placeholder' => 'Choisir le type de compétition',
                'choices'  => array(
                    'Championnat' => 'Champ',
                    'Coupe' => 'Coupe',
                    'Tournoi' => 'Tournoi',
                ),
            ))
            ->add('reference', TextType::class)
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => RefCompetition::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_equipe_refcompetition';
    }


}
