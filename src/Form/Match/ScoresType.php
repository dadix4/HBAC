<?php

namespace App\Form\Match;

use App\Entity\Match\Match;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;

class ScoresType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('competition', TextType::class, array(
                'label' => false,
                'disabled' => true
            ))
            ->add('local', TextType::class, array(
                 'label' => false,
                'disabled' => true
            ))
            ->add('scoreLocal', TextType::class, array(
                'required' => false,
                'label' => false,
                'attr' => array(
                    'placeholder' => "Score local")))
            ->add('scoreVisiteur', TextType::class, array(
                'required' => false,
                'label' => false,
                'attr' => array(
                    'placeholder' => "Score visiteur")))
            ->add('visiteur', TextType::class, array(
                 'label' => false,
                'disabled' => true
            ));
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Match::class,
        ));
    }
}