<?php

namespace App\Form\Match;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MatchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class,[
                'required'  => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy',
                    'placehorlder' => 'Renseigner la date du match'
                ]])
            ->add('heure',TimeType::class,[
                'required'  => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input-inline clockpicker',
                ]])
            ->add('local',TextType::class)
            ->add('numReceveur',TextType::class, array('required' => false))
            ->add('visiteur',TextType::class)
            ->add('numVisiteur',TextType::class, array('required' => false))
            ->add('competition',TextType::class)
            ->add('poule',TextType::class)
            ->add('numPoule',TextType::class, array('required' => false))
            ->add('nomSalle',TextType::class, array('required' => false))
            ->add('adresseSalle',TextType::class, array('required' => false))
            ->add('cpSalle',TextType::class, array('required' => false))
            ->add('ville',TextType::class)


        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Match\Match'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_match_match';
    }


}
