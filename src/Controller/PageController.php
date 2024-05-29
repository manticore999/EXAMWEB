<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->render('page/index.html.twig');
    }

    /**
     * @Route("/restaurants", name="restaurants")
     */
    public function restaurants(): Response
    {
        // This is where you would fetch restaurant data and pass it to the template
        return $this->render('page/restaurants.html.twig');
    }

    /**
     * @Route("/signup", name="signup")
     */
    public function signup(): Response
    {
        return $this->render('login/signup.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(): Response
    {
        return $this->render('login/index.html.twig');
    }
}
