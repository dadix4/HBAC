<?php

namespace App\Form\Event;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ReservationType extends AbstractType
{

    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager  = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $entityManager = $options['entity_manager'];
        $evenement = $options['evenement'];
        // ...


        $builder
            ->add('nomReservation', TextType::class )
            ->add('telReservation', TextType::class )
            ->add('inscrits', CollectionType::class , array(
                'entry_type'   => InscritType::class,
                'entry_options'  => array(
                    'entity_manager' => $entityManager,
                    'evenement' => $evenement),
                'allow_add'    => true,
                'allow_delete' => true,
                'label' => false,
                'prototype'    => true,
                'required'     => false,
                'by_reference' => false,
            ));

    }
    
    /**s
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('entity_manager');
        $resolver->setRequired('evenement');
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Event\Reservation',
            'evenement' => null,
            'session'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_event_reservation';
    }


}
