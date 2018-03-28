<?php

namespace App\Form\Event;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InscritType extends AbstractType
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
        //on recherche l'evenement via l'
        $event = $entityManager->getRepository('App:Event\Evenement')->find($evenement);


        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class);

        //si l'option gratuit n'est pas coché, on affiche le tarif
        if ($event->getGratuit() == 0 ) {
            $builder
                ->add('tarif', EntityType::class, array(
                    'class' => 'App\Entity\Event\Tarif',
                    'choice_label' => 'getTitreetPrix',
                    'multiple' => false,
                    'expanded' => false,
                    'placeholder' => "Choix du tarif",
                    'query_builder' => function(EntityRepository $er ) use ($evenement) {
                        return $er->createQueryBuilder('t')
                            ->where('t.evenement =:evenement')
                            ->setParameter('evenement', $evenement);}
                ));
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired('entity_manager');
        $resolver->setRequired('evenement');
        $resolver->setAllowedTypes('evenement', 'integer');
        $resolver
            ->setDefaults(array(
            'data_class' => 'App\Entity\Event\Inscrit',
        ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_event_inscrit';
    }


}
