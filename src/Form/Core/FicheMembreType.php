<?php

namespace App\Form\Core;

use App\Entity\Core\Bureau\Fonction;
use App\Entity\Core\Licencie;
use App\Entity\Core\Saison;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;


class FicheMembreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('licencies', EntityType::class, array(
                'class'    => Licencie::class,
                'choice_label' => 'getPrenomNom',
                'multiple' => false,
                'expanded' => false,
                'attr' => array(
                    'class'=>'selectpicker',
                    'data-live-search' => 'true',
                    'title' => "Choisir un membre",
                    'data-size' => "5",),
                'query_builder' => function(EntityRepository $er ) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.nom', 'ASC');
                }))

            ->add('saison', EntityType::class, array(
                'class'    => Saison::class,
                'choice_label' => 'nomSaison',
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class'=>'selectpicker'),
                'query_builder' => function(EntityRepository $er ) {
                            return $er->createQueryBuilder('s')
                                 ->orderBy('s.nomSaison', 'DESC');
            }))

            ->add('fonctions', EntityType::class , array(
                'class'    => Fonction::class,
                'choice_label' => 'fonction',
                'multiple' => true,
                'attr' => array(
                    'class'=>'selectpicker',
                    'data-actions-box'=> 'true',
                    'title' => "Choix des fonctions"),
                'query_builder' => function(EntityRepository $er ) {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.hierarchie', 'ASC');
                }))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Core\Bureau\FicheBureau'
        ));
    }
}
