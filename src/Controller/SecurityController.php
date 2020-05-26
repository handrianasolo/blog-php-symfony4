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

            return $this->redirectToRoute('articles_page');
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

            return $this->redirectToRoute('article_page', [
                'id' => $article->getId()
            ]);
        }

        return $this->render("blog/article-form.html.twig", [
            "form_title" => "Add a new article",
            // generate the article form's view in html page
            "form_article" => $form->createView()
        ]);
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
