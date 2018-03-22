<?php

namespace Hbac\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Hbac\EquipeBundle\Form\ImageType;


class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('date_register', 'datetime', [
                'required'  => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy'
                ]])
            ->add('username')
            ->add('email')
            ->add('image',      new ImageType(),array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Photo',
                )))
            ->add('membre', 'entity', array(
                'class'    => 'HbacCoreBundle:Membres',
                'property' => 'getPrenomNom',
                'multiple' => false,
                'expanded' => false,
                'attr' => array(
                    'class'=>'selectpicker',
                    'data-live-search' => 'true',
                    'title' => "Choisir un membre",
                    'data-size' => "5",)
            ))
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
            'data_class' => 'Hbac\UserBundle\Entity\User'
        ));
    }
}
