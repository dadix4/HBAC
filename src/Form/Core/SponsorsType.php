<?php

namespace Hbac\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Hbac\EquipeBundle\Form\ImageType;

class SponsorsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', 'text',array(
                'attr' => array(
                    'placeholder' => 'Nom du Sponsors',)))

            ->add('mail', 'text',array(
                'required'  => false,
                'attr' => array(
        '           placeholder' => 'Adresse Email*',)))

            ->add('tel', 'text',array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Téléphone*',)))

            ->add('adresse', 'text',array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Adresse*',)))

            ->add('cpmtadresse', 'text',array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Complément Adresse*',)))

            ->add('codepostal', 'text',array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Code Postal*',)))

            ->add('ville', 'text',array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Vile*',)))

            ->add('web','url',array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Lien site web*',)))

            ->add('image',      new ImageType(),array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Photo*',
                )))
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
            'data_class' => 'Hbac\CoreBundle\Entity\Sponsors'
        ));
    }
}
