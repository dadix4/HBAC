<?php

namespace App\Controller\Blog;

use App\Entity\Blog\Article;
use App\Entity\Blog\Commentaire;
use App\Form\Blog\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends Controller
{
    //Création du formulaire de commentaire puis affichage via un render controller
    public function FormCommentAction(Article $article)
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);

        return $this->render('blog/comment/formComment.html.twig', array(
            'form'   => $form->createView(),
            'article' => $article
        ));
    }

    //Traitement du formulaire POST submit
    public function AddCommentAction(Request $request, Article $article)
    {
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $commentaire -> setArticle($article);
            $em->persist($commentaire);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success','Votre commentaire à été publié avec succès');

            return $this->redirectToRoute('view_blog', array('id' => $article->getId(), 'slug'=> $article->getSlug()));
        }
    }
}