<?php

namespace App\Form\Ecommerce;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RechercheType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder->add('recherche', TextType::class, array('label' => false,
                                                        'attr' => array('class' => 'form-control rounded-0 u-form-control g-brd-white',
                                                                        'placeholder' => 'Entrez Votre Recherche')));
  }

  public function getName()
  {
      return 'app_recherche';
  }
}
