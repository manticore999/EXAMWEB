<?php

namespace App\Controller;

use App\Entity\Personne;
use App\Repository\PersonneRepository;
use Doctrine\ORM\EntityManagerInterface;
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
    private $entityManager;

    public function __construct(PersonneRepository $personneRepository, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->personneRepository = $personneRepository;
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
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

    /**
     * @Route("/signup", name="signup")
     */
    public function signup(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            $username = $request->request->get('username');
            $email = $request->request->get('email');
            $password = $request->request->get('password');
            $confirmPassword = $request->request->get('confirm_password');

            if ($username && $email && $password && $confirmPassword) {
                if ($password !== $confirmPassword) {
                    $this->addFlash('danger', 'Passwords do not match.');
                } else {
                    $existingUser = $this->personneRepository->findOneByUsername($username) ??
                        $this->personneRepository->findOneByEmail($email);

                    if ($existingUser) {
                        $this->addFlash('danger', 'Username or email already taken.');
                    } else {
                        $user = new Personne();
                        $user->setUsername($username);
                        $user->setEmail($email);
                        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

                        $this->entityManager->persist($user);
                        $this->entityManager->flush();

                        $this->addFlash('success', 'Account created successfully.');
                        return $this->redirectToRoute('login');
                    }
                }
            } else {
                $this->addFlash('danger', 'Please complete all fields.');
            }
        }

        return $this->render('login/signup.html.twig');
    }
}
