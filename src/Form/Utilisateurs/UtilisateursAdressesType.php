<?php

namespace App\Form\Utilisateurs;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;



class UtilisateursAdressesType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $options['entity_manager'];

        $builder
        ->add('nom', TextType::class, array('label' => false,'attr' => array(
              'class' => 'form-control g-brd-gray-light-v4 g-brd-primary--focus g-color-text rounded g-py-13 g-px-15',
              'placeholder' => 'Entrez Votre Nom')))
        ->add('prenom', TextType::class, array('label' => false,'attr' => array(
              'class' => 'form-control g-brd-gray-light-v4 g-brd-primary--focus g-color-text rounded g-py-13 g-px-15',
              'placeholder' => 'Entrez Votre Prénom')))
        ->add('telephone', TextType::class, array('label' => false,'attr' => array(
              'class' => 'form-control g-brd-gray-light-v4 g-brd-primary--focus g-color-text rounded g-py-13 g-px-15',
              'placeholder' => 'Renseignez votre numero de téléphone')))
        ->add('adresse', TextType::class, array('label' => false,'attr' => array(
              'class' => 'form-control g-brd-gray-light-v4 g-brd-primary--focus g-color-text rounded g-py-13 g-px-15',
              'placeholder' => 'Entrez Votre Adresse')))
        ->add('complement', TextType::class, array('label' => false,'required' => false, 'attr' => array(
              'class' => 'form-control g-brd-gray-light-v4 g-brd-primary--focus g-color-text rounded g-py-13 g-px-15',
              'placeholder' => 'Complément Adresse')))

        ->add('cp',  TextType::class, array(
                     'label' => false,
                     'attr' => array(
                                        //form-control g-brd-gray-light-v4 g-brd-primary--focus g-color-text rounded g-py-13 g-px-15
                            'class' => 'cp form-control g-brd-gray-light-v4 g-brd-primary--focus g-color-text rounded g-py-13 g-px-15',
                            'placeholder' => 'Code Postal',
                            'maxlength' => 5
                     )))

        ->add('ville', ChoiceType::class, array(
                     'label' => false,
                     'attr' => array(
                            'class' => 'ville ',
                            'placeholder' => 'Ville')))

        ->add('pays', TextType::class, array('label' => false, 'attr' => array(
              'class' => 'pays form-control g-brd-gray-light-v4 g-brd-primary--focus g-color-text rounded g-py-13 g-px-15',
              'placeholder' => 'Pays')));


        $city = function (FormInterface $form, $cp){
            $villesCP = $this->em->getRepository('App:VillesFrance')->byCodePostal($cp);

            if($villesCP) {
                $villes = array();
                foreach ($villesCP as $ville){
                    $villes[] = $ville->getVilleNomReel();
                }
            }
            else
            {
                $ville = null ;
            }
            $form->add('ville', ChoiceType::class, array(
                'choices' => $villes,
                'label' => false,
                'attr' => array(
                    'class' => 'ville ',
                    'placeholder' => 'Ville')));

        };

        $builder->get('cp')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($city){
            $city($event->getForm()->getParent(),$event->getForm()->getData());
        });
    }





    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\Utilisateurs\UserAdresses'
        ));
        $resolver->setRequired('entity_manager');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_utilisateurs_utilisateursadresses';
    }


}
