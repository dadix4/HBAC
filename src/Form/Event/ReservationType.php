<?php

namespace Hbac\EventBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ReservationType extends AbstractType
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
            ->add('nomreservation', TextType::class )
            ->add('telreservation', TextType::class )
            ->add('inscrits', CollectionType::class , array(
                'type'         => new InscritType($event,$tarifs),
                'allow_add'    => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => false,
            ))
            ->add('captcha', 'ds_re_captcha', array('mapped' => false))
            ->add('envoyer', SubmitType::class ,array(
                'attr' => array(
                    'placeholder' => 'Envoyer',)));
    }
    
    /**s
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Hbac\EventBundle\Entity\Reservation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'hbac_eventbundle_reservation';
    }


}
