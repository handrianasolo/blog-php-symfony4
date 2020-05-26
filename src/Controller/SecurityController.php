<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function registrate()
    {
        return $this->render('security/registration.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
}
