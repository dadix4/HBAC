<?php

namespace Hbac\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FonctionsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fonction')
            ->add('type', 'choice',
                array('choices' => array(
                    'Bureau' => "Bureau",
                    'Conseil d\'Administration' => "Conseil d'Administration",
                    'Commission' => "Commission"),
                    'multiple' => false,
                    'expanded' => true,
                    'empty_value' => ''
                ))
            ->add('hierarchie')
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
            'data_class' => 'Hbac\CoreBundle\Entity\Fonctions'
        ));
    }
}
