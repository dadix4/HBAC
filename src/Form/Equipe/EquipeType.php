<?php

namespace App\Form\Equipe;



use App\Entity\Equipe\Equipe;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('convention',TextType::class, array('required'  => false))
            ->add('urlfhh',TextType::class, array('required'  => false))
            ->add('division', TextType::class, array('required'  => false))
            ->add('joueurs', EntityType::class, array(
                'class'    => 'App:Core\Licencie',
                'choice_label' => 'getPrenomNom',
                'multiple' => true,
                'expanded' => false,
                'required'  => false,
                'attr' => array(
                    'class'=>'selectpicker',
                    'data-live-search' => 'true',
                    'title' => "Selectionner les joueurs de l'équipe",
                    'data-size' => "10",)
            ))
            ->add('entraineurs', EntityType::class, array(
                'class'    => 'App:Core\Licencie',
                'choice_label' => 'getPrenomNom',
                'multiple' => true,
                'expanded' => false,
                'required'  => false,
                'attr' => array(
                    'class'=>'selectpicker',
                    'data-live-search' => 'true',
                    'title' => "Selectionner les entraineurs",
                    'data-size' => "10",)
            ))
            ->add('categorie', EntityType::class , array(
                'class'    => 'App:Equipe\Categorie',
                'choice_label' => 'categorieEquipe',
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function(EntityRepository $er ){
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.hierarchie','ASC');
                }))
            ->add('image', ImageType::class, array('required'  => false))
            ->add('refCompetitions', CollectionType::class, array(
                'entry_type'   => RefCompetitionType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'label' => false,
                'prototype'    => true,
                'required'     => false,
                'by_reference' => false,
            ))

;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Equipe::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_equipe_equipe';
    }


}
