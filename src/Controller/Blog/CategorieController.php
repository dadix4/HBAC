<?php

namespace App\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CategorieController extends Controller
{
    public function CategoriesSidebarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('App:Blog\Categorie')->findAll();
        return $this->render('blog/sidebar/categories.html.twig', array('categories' => $categories));
    }

}