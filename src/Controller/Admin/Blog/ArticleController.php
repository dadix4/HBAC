<?php

namespace App\Controller\Admin\Blog;

use App\Entity\Blog\Article;
use App\Entity\Blog\Categorie;
use App\Form\Blog\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Article controller.
 *
 */
class ArticleController extends Controller
{
    /**
     * Lists all article entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $actus = $em->getRepository('App:Blog\Article')->findAll();
        $articles  = $this->get('knp_paginator')->paginate($actus,$request->query->get('page', 1),15); // "1" pour numero de page et "10" pour le nombre de produit par page.

        return $this->render('admin/blog/article/index.html.twig', array(
            'articles' => $articles,
        ));
    }

    /**
     * Creates a new article entity.
     *
     */
    public function newAction(Request $request)
    {
        $article = new Article();
        $form = $this->createForm('App\Form\Blog\ArticleType', $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('admin_blog_article_show', array('id' => $article->getId()));
        }

        return $this->render('admin/blog/article/new.html.twig', array(
            'article' => $article,
            'form' => $form->createView(),
        ));
    }


    public function newCategorieAction(Request $request) {

        $newCategorie = new Categorie();
        $categorieForm = $this->createForm(CategorieType::class, $newCategorie);
        $categorieForm->handleRequest($request);

        if ($categorieForm->isSubmitted() && $categorieForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($newCategorie);
            $em->flush();

            return $this->redirectToRoute('admin_blog_article_new');
        }

        return $this->render("admin/blog/article/newCategorie.html.twig", array(
            'form_categorie'  =>  $categorieForm->createView()
        ));
    }

    /**
     * Finds and displays a article entity.
     *
     */
    public function showAction(Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);

        return $this->render('admin/blog/article/show.html.twig', array(
            'article' => $article,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing article entity.
     *
     */
    public function editAction(Request $request, Article $article)
    {
        $deleteForm = $this->createDeleteForm($article);
        $editForm = $this->createForm('App\Form\Blog\ArticleType', $article);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_blog_article_edit', array('id' => $article->getId()));
        }

        return $this->render('admin/blog/article/edit.html.twig', array(
            'article' => $article,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a article entity.
     *
     */
    public function deleteAction(Request $request, Article $article)
    {
        $form = $this->createDeleteForm($article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($article);
            $em->flush();
        }

        return $this->redirectToRoute('admin_blog_article_index');
    }

    /**
     * Creates a form to delete a article entity.
     *
     * @param Article $article The article entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Article $article)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_blog_article_delete', array('id' => $article->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
