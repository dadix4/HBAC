<?php

namespace App\Controller\Ecommerce;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoriesController extends Controller
{
  public function navigationAction()
  {
      $em = $this->getDoctrine()->getManager();
      $categories = $em->getRepository('App:Ecommerce\Categories')->findAll();
      return $this->render('boutique/categories/navigation.html.twig', array('categories' => $categories));
  }
}
