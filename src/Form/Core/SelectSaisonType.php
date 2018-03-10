<?php

namespace App\Form\Core;

use App\Entity\Core\Saison;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SelectSaisonType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomSaison', EntityType::class, array(
                'class'    => Saison::class,
                'choice_label' => 'nomSaison',
                'multiple' => false,
                'expanded' => false,
                'query_builder' => function(EntityRepository $er ){
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.active','DESC')
                        ->addOrderBy('s.slug' , 'DESC');
                }));

    }/**
 * {@inheritdoc}
 */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Core\Saison'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_core_saison';
    }


}
