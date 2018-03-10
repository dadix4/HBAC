<?php

namespace App\Controller\Ecommerce;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Form\Ecommerce\RechercheType;


class ProduitController extends Controller
{

    public function produitsAction($categorie = null, Request $request)
    {
      $session = $request->getSession();
      $em = $this->getDoctrine()->getManager();


      if ($categorie != null) {
          $exist = $em->getRepository('App:Ecommerce\Categories')->find($categorie);
      }

      if ($categorie != null && $exist != "" ) {
          $findProduits = $em->getRepository('App:Ecommerce\Produits')->byCategorie($categorie);
      } elseif ($categorie == null) {
          $findProduits = $em->getRepository('App:Ecommerce\Produits')->findBy(array('disponible' => 1));
      } else {
          throw $this->createNotFoundException('La page n\'existe pas.');
      }

      if ($session->has('panier')) {
          $panier = $session->get('panier');
      } else {
          $panier = false;
      }

      $produits  = $this->get('knp_paginator')->paginate($findProduits,$request->query->get('page', 1),10); // "1" pour numero de page et "10" pour le nombre de produit par page.

      return $this->render('boutique/produits/produit.html.twig', array('produits' => $produits,
                                                                                  'panier' => $panier));
    }


    public function presentationAction($id, Request $request)
    {
      $session = $request->getSession();
      $em = $this->getDoctrine()->getManager();
      $produit = $em->getRepository('App:Ecommerce\Produits')->find($id);

      if (!$produit) throw $this->createNotFoundException('La page n\'existe pas.');

      if ($session->has('panier')) {
          $panier = $session->get('panier');
      } else {
          $panier = false;
      }

      return $this->render('boutique/produits/presentation.html.twig', array('produit' => $produit,
                                                                                        'panier' => $panier));
    }

    public function rechercheAction()
    {
      $form = $this->createForm(RechercheType::class);
      return $this->render('recherche/recherche.html.twig', array('form' => $form->createView()));
    }

    public function rechercheTraitementAction()
    {
      $request = Request::createFromGlobals();
      $form = $this->createForm(RechercheType::class);
      if ($request->getMethod()== 'POST'){
          $form->handleRequest($request);
          $em = $this->getDoctrine()->getManager();
          $findProduits = $em->getRepository('App:Ecommerce\Produits')->recherche($form['recherche']->getData());
      } else {
          throw $this->createNotFoundException('La page n\'existe pas.');
      }

      $produits  = $this->get('knp_paginator')->paginate($findProduits,$request->query->get('page', 1),10); // "1" pour numero de page et "10" pour le nombre de produit par page.

      return $this->render('boutique/produits/produit.html.twig', array('produits' => $produits ));
    }

}
