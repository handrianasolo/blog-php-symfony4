<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentFormType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="blog_home")
     */
    public function home(ArticleRepository $repository){

        $articles = $repository->findAll();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles", name="blog_articles_page")
     */
    public function getAllArticles(ArticleRepository $repository){

        $articles = $repository->findAll();

        return $this->render('blog/index.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article={id}", name="blog_article_page")
     */
    public function getArticleBy(Request $request, ArticleRepository $repository, $id){

        $article = $repository->find($id);

        $comment = new Comment();
        // generate the form type and hydrate automatically the object using request method
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comment->setArticle($article);
            $comment->setCreatedAt(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('article_page',[
                'id' => $article->getId()
            ]);
        }

        return $this->render('/blog/article.html.twig', [
            'article' => $article,
            // generate the comment form's view in html page
            "form_comment" => $form->createView()
        ]);

    }  
}
