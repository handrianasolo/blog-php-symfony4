<?php

namespace App\Controller;

use App\Entity\Comment;
<<<<<<< HEAD
use App\Entity\PropertySearch;
use App\Form\CommentFormType;
use App\Form\PropertySearchType;
=======
use App\Form\CommentFormType;
>>>>>>> d7cdad896d6bd18b72581a21e96b3951c3144990
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="blog_home")
     */
    public function home(ArticleRepository $repository, Request $request, PaginatorInterface $paginator){

        // récuperer les données avec des critères de filtre et de tri
        $data = $repository->findBy([], ['createdAt' => 'desc']);

        $articles = $paginator->paginate(
            $data, // on passe les données
            $request->query->getInt('page', 1), // numero de la page en cours, 1 par défaut
            3
        );

        return $this->render('blog/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles", name="blog_articles_page")
     */
    public function getArticles(ArticleRepository $repository){

        $articles = $repository->findAll();

        return $this->render('blog/index.html.twig',[
            'articles' => $articles
        ]);
    }

    /**
<<<<<<< HEAD
     * @Route("/article={title}", name="blog_article_page")
     */
    public function getArticleBy(Request $request, ArticleRepository $repository, $title){

        $article = $repository->findOneBy(['title' => $title]);

=======
     * @Route("/article={id}", name="blog_article_page")
     */
    public function getArticleBy(Request $request, ArticleRepository $repository, $id){

        $article = $repository->find($id);

>>>>>>> d7cdad896d6bd18b72581a21e96b3951c3144990
        $comment = new Comment();
        // generate the form type and hydrate automatically the object using request method
        $form = $this->createForm(CommentFormType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comment->setArticle($article);
            $comment->setAuthor($this->getUser()->getUsername());
            $comment->setCreatedAt(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('blog_article_page',[
<<<<<<< HEAD
                'title' => $article->getTitle()
=======
                'id' => $article->getId()
>>>>>>> d7cdad896d6bd18b72581a21e96b3951c3144990
            ]);
        }

        return $this->render('/blog/article.html.twig', [
            'article' => $article,
            // generate the comment form's view in html page
            "form_comment" => $form->createView()
        ]);

<<<<<<< HEAD
    }
=======
    }  
>>>>>>> d7cdad896d6bd18b72581a21e96b3951c3144990
}
