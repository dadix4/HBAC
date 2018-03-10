<?php

namespace App\Form\Blog;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class )
            ->add('contenu',TextareaType::class , array('attr' => array('class' => 'tinymce',)))
            ->add('image', ImageType::class)
            ->add('categories', EntityType::class , array(
                'class'    => 'App:Blog\Categorie',
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => false,
                'required'  => false,
                'attr' => array(
                    'class'=>'selectpicker',
                    'data-live-search' => 'false',
                    'title' => "Selectionner ou ajouter une categorie",
                    'data-size' => "5",)
            ))

;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Blog\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_blog_article';
    }


}
