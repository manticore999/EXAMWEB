<?php

namespace App\Controller;

use App\Repository\PersonneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{
    private $personneRepository;
    private $passwordHasher;

    public function __construct(PersonneRepository $personneRepository, UserPasswordHasherInterface $passwordHasher)
    {
        $this->personneRepository = $personneRepository;
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $usernameOrEmail = $request->request->get('username_or_email');
            $password = $request->request->get('password');

            if ($usernameOrEmail && $password) {
                $user = $this->personneRepository->findOneByUsername($usernameOrEmail) ??
                    $this->personneRepository->findOneByEmail($usernameOrEmail);

                if ($user && $this->passwordHasher->isPasswordValid($user, $password)) {
                    $session = $request->getSession();
                    $session->set('username', $user->getUsername());
                    $session->set('user_id', $user->getId());

                    return $this->redirectToRoute('dashboard');
                } else {
                    $this->addFlash('danger', 'Invalid username/email and password combination.');
                }
            } else {
                $this->addFlash('danger', 'Please complete all fields.');
            }
        }

        return $this->render('login/index.html.twig');
    }
}
