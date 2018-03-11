<?php

namespace Hbac\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;


class FichemembreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('membres', 'entity', array(
                'class'    => 'HbacCoreBundle:Membres',
                'property' => 'getPrenomNom',
                'multiple' => false,
                'expanded' => false,
                'attr' => array(
                    'class'=>'selectpicker',
                    'data-live-search' => 'true',
                    'title' => "Choisir un membre",
                    'data-size' => "5",),
                'query_builder' => function(EntityRepository $er ) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.name', 'ASC');
                }))

            ->add('saison', 'entity', array(
                'class'    => 'HbacEquipeBundle:Saison',
                'property' => 'nomsaison',
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class'=>'selectpicker'),
                'query_builder' => function(EntityRepository $er ) {
                            return $er->createQueryBuilder('s')
                                 ->orderBy('s.nomSaison', 'DESC');
            }))

            ->add('fonctions', 'entity', array(
                'class'    => 'HbacCoreBundle:Fonctions',
                'property' => 'fonction',
                'multiple' => true,
                'attr' => array(
                    'class'=>'selectpicker',
                    'data-actions-box'=> 'true',
                    'title' => "Choix des fonctions"),
                'query_builder' => function(EntityRepository $er ) {
                    return $er->createQueryBuilder('f')
                        ->orderBy('f.hierarchie', 'ASC');
                }))

            ->add('save',      'submit',array(
                'attr' => array(
                    'class' => 'btn btn-info'
                )))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hbac\CoreBundle\Entity\Fichemembre'
        ));
    }
}
