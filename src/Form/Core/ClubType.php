<?php

namespace App\Form\Core;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClubType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomClub', TextType::class)
            ->add('abreviation', TextType::class)
            ->add('numeroFederal', TextType::class)
            ->add('monclub', CheckboxType::class, array(
                'label'    => 'Mon club',
                'required' => false,))
            ->add('convention', CheckboxType::class, array(
                'label'    => 'Club en convention',
                'required' => false,))
            ->add('couleur1', TextType::class ,array(
                'required'  => false ))
            ->add('couleur2', TextType::class ,array(
                'required'  => false ))
            ->add('logo', ClubLogoType::class,array(
                'label' => false,
                'required'  => false,))
            ->add('siteInternet', TextType::class ,array(
                'required'  => false ))
            ->add('facebook', TextType::class,array(
                'required'  => false ))
            ->add('nomGymnase', TextType::class,array(
                'required'  => false ))
            ->add('adresse1', TextType::class,array(
                'required'  => false ))
            ->add('adresse2', TextType::class,array(
                'required'  => false ))
            ->add('codePostale', TextType::class,array(
                'required'  => false ))
            ->add('ville', TextType::class,array(
                'required'  => false ))
        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Core\Club'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_core_club';
    }


}
