<?php

namespace App\Form\Core;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FonctionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fonction')
            ->add('groupe', ChoiceType::class,
                array('choices' => array(
                    'Bureau' => "Bureau",
                    'Conseil d\'Administration' => "Conseil d'Administration",
                    'Commission' => "Commission"),
                    'multiple' => false,
                    'expanded' => true,
                ))
            ->add('hierarchie', TextType::class);
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Core\Bureau\Fonction'
        ));
    }
}
