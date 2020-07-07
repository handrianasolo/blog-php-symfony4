<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Article;
use App\Form\ArticleFormType;
use App\Form\RegistrationFormType;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * @Route("/register", name="security_register")
     */
    public function createUser(Request $request, UserPasswordEncoderInterface $encoder){

        $user = new User();
        // generate the form type and hydrate automatically the object using request method
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('blog_articles_page');
        }

        return $this->render("security/registration-form.html.twig", [
            "form_title" => "Registration",
            // generate the article form's view in html page
            "form_register" => $form->createView()
        ]);

    }

    /**
     * @Route("/add", name="security_article_add")
     */
    public function createArticle(Request $request){

        $article = new Article(); 
        // generate the form type and hydrate automatically the object using request method
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $article->setUser($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            return $this->redirectToRoute('blog_article_page', [
                'title' => $article->getTitle()
            ]);
        }

        return $this->render("blog/article-form.html.twig", [
            "form_title" => "Add a new article",
            // generate the article form's view in html page
            "form_article" => $form->createView()
        ]);
    }

    /**
     * @Route("/myArticles", name="security_index")
    */
    public function index(ArticleRepository $repository){
        // récuperer les données avec des critères de filtre et de tri
        $articles = $repository->findBy([], ['createdAt' => 'desc']);

        return $this->render('security/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/edit/article={id}", name="security_article_edit")
    */
    public function editArticle(Request $request, $id){

        $entityManager = $this->getDoctrine()->getManager();

        $article = $entityManager->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleFormType::class, $article);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager->flush();

            return $this->redirectToRoute('security_index');
        }

        return $this->render("blog/article-form.html.twig", [
            "form_title" => "Modification",
            "form_article" => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/article={id}",name="security_article_delete")
    */
    public function deleteArticle($id){
        
        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Article::class)->find($id);
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->redirectToRoute('security_index');
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(){
        return $this->render('security/login-form.html.twig', [
            'form_title' => 'Connexion'
        ]);
    }

        /**
     * @Route("/logout", name="security_logout")
     */
    public function logout(){}
}
