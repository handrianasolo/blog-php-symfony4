<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function home(ArticleRepository $repository){

        $articles = $repository->findAll();

        return $this->render('blog/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/articles", name="articles_page")
     */
    public function index(ArticleRepository $repository){

        $articles = $repository->findAll();

        return $this->render('blog/index.html.twig',[
            'articles' => $articles
        ]);
    }

    
    /**
     * @Route("/add", name="article_add")
     */
    public function create(Request $request){

        $article = new Article(); 
        // generate the form type and hydrate automatically the object using request method
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('articles_page');
        }

        return $this->render("blog/article-form.html.twig", [
            "form_title" => "Add a new article",
            // generate the form's view in html page
            "form_article" => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/article={id}", name="article_page")
     */
    public function article(ArticleRepository $repository, $id){

        $article = $repository->find($id);

        return $this->render('/blog/article.html.twig', [
            'article' => $article
        ]);
    }

}
