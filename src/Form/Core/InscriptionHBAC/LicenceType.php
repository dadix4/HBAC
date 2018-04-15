<?php

namespace App\Form\Core\InscriptionHBAC;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class CheckLicenceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class , [
                'label'    => 'Prénom',
                'attr' => [
                    'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15',
                ]])
            ->add('nom', TextType::class, [
                'label'    => 'Nom',
                'attr' => [
                    'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15',
                ]])
            ->add('birthday', BirthdayType::class,[
                'label'    => 'Date d\'anniversaire',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datepickerDefault g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15',
                ]]);
    }

    public function getId()
    {
       return Null;
    }

}