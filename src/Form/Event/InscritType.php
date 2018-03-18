<?php

namespace Hbac\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InscritType extends AbstractType
{
    private $event;
    private $tarifs;
    public function __construct($event, $tarifs)
    {
        $this->event=$event;
        $this->tarifs=$tarifs;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $event =$this->event;
        $tarifs =$this->tarifs;


        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class);



        //On affiche seulement le champ tarif si l'event à un ou des tarifs.
        if ($tarifs != 0 ) {
        $builder
            ->add('tarif', EntityType::class, array(
                'class'    => 'Hbac\EventBundle\Entity\Tarif',
                'property' => 'getTitreetPrix',
                'multiple' => false,
                'expanded' => false,
                'placeholder'=> "Choix du tarif",
                'query_builder' => function(EntityRepository $er ) use ($event) {
                    return $er->createQueryBuilder('t')
                        ->where('t.event =:event')
                        ->setParameter('event', $event);
                }
            ));
        }

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults(array(
            'data_class' => 'Hbac\EventBundle\Entity\Inscrit',
            'event' => null))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hbac_eventbundle_inscrit';
    }


}
