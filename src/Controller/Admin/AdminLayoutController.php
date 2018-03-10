<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Produit controller.
 *
 */
class AdminLayoutController extends Controller
{

  /**
   * Affichage du menu
   *
   */
  public function menuLayoutAction()
  {
      return $this->render('admin/menus/menuAdmin.html.twig');
  }

}
