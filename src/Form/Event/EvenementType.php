<?php

namespace App\Form\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class )
            ->add('mailnotification', EmailType::class)
            ->add('gratuit', CheckboxType::class, array(
                'label'    => "A COCHER SI EVENEMENT GRATUIT",
                'required' => false,))
            ->add('resaequipe', CheckboxType::class, array(
                'label'    => "Réservation d'une Equipe",
                'required' => false,))
            ->add('resagroupe', CheckboxType::class, array(
                'label'    => "Réservation d'un Groupe",
                'required' => false,))

            ->add('description', TextareaType::class , array('attr' => array('class' => 'tinymce',)))
            ->add('date', DateType::class,[
                'required'  => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy',
                ]])

            ->add('heure',TimeType::class,[
                'required'  => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'input-inline clockpicker',
                ]])

            ->add('datelimit', DateType::class,[
                'required'  => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy',
                ]])

            ->add('tarifs', CollectionType::class , array(
                'entry_type'   => TarifType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'label' => false,
                'prototype'    => true,
                'required'     => false,
                'by_reference' => false,
            ))

            ->add('image',      ImageType::class ,array(
                'required'  => false ))

            ->add('bodymail', TextareaType::class , array('attr' => array('class' => 'tinymce',)))

                ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Event\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'App_event_evenement';
    }


}
