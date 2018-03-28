<?php

namespace App\Form\Utilisateurs;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {


        $builder
            ->add('createdAt', DateType::class , [
                'required'  => false,
                'widget' => 'single_text',
                'format' => 'dd-MM-yyyy',
                'attr' => [
                    'class' => 'form-control input-inline datepicker',
                    'data-provide' => 'datepicker',
                    'data-date-format' => 'dd-mm-yyyy'
                ]])
            ->add('username', TextType::class)
            ->add('email', EmailType::class )
            ->add('avatar', AvatarType::class ,array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Photo',
                )))
            ->add('adherent', EntityType::class, array(
                'class'    => 'App:Core\Licencie',
                'choice_label' => 'getPrenomNom',
                'multiple' => false,
                'expanded' => false,
                'attr' => array(
                    'class'=>'selectpicker',
                    'data-live-search' => 'true',
                    'title' => "Choisir un membre",
                    'data-size' => "10",)
            ))
        ;
    }

    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Utilisateurs\User'
        ));
    }
}
