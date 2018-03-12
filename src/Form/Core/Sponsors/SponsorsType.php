<?php

namespace App\Form\Core;

use App\Entity\Equipe\Image;
use App\Form\Equipe\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class SponsorsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class ,array(
                'attr' => array(
                    'placeholder' => 'Nom du Sponsors',)))

            ->add('mail', TextType::class ,array(
                'required'  => false,
                'attr' => array(
        '           placeholder' => 'Adresse Email*',)))

            ->add('tel', TextType::class ,array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Téléphone*',)))

            ->add('adresse', TextType::class ,array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Adresse*',)))

            ->add('cpmtadresse', TextType::class  ,array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Complément Adresse*',)))

            ->add('codepostal', TextType::class ,array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Code Postal*',)))

            ->add('ville', TextType::class  ,array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Vile*',)))

            ->add('web', UrlType::class ,array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Lien site web*',)))

            ->add('image', ImageType::class ,array(
                'required'  => false,
                'attr' => array(
                    'placeholder' => 'Photo*',
                )))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Core\Sponsors'
        ));
    }
}
