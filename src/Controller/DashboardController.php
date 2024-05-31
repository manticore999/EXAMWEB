<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Review;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard(EntityManagerInterface $em): Response
    {
        $reviews = $em->getRepository(Review::class)->findBy(['user' => $this->getUser()]);

        return $this->render('dashboard.html.twig', [
            'reviews' => $reviews,
        ]);
    }
}