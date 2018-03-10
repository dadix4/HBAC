<?php

namespace App\Controller\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class ActualiteController extends Controller
{
    public function IndexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $actus = $em->getRepository('App:Blog\Article')->findAllActu();

        $articles  = $this->get('knp_paginator')->paginate($actus,$request->query->get('page', 1),5); // "1" pour numero de page et "10" pour le nombre de produit par page.

        return $this->render('blog/articles/index.html.twig', array('articles' => $articles));
    }

    public function ArticlesCategorieAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository('App:Blog\Categorie')->findBySlug($slug);
        $articles = $em->getRepository('App:Blog\Article')->byCategorie($slug);
        return $this->render('blog/articles/byCategorie.html.twig',
            array('articles' => $articles,
                  'categorie' =>$categorie
            ));
    }

    public function ArticlesSidebarAction()
    {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('App:Blog\Article')->ActuSidebar();
        return $this->render('blog/sidebar/articles.html.twig', array('articles' => $articles));
    }

    public function ViewPostAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('App:Blog\Article')->find($id);

        if (!$article) {
            throw $this->createNotFoundException("Cet article n'existe pas !");
        }

        return $this->render('blog/articles/viewBlog.html.twig', array('article' => $article));
    }
}