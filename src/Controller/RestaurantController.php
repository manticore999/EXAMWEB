<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Restaurant;
use App\Entity\Review;

class RestaurantController extends AbstractController
{
    /**
     * @Route("/restaurant/{id}", name="restaurant_detail")
     */
    public function restaurantDetail(int $id, EntityManagerInterface $em): Response
    {
        $restaurant = $em->getRepository(Restaurant::class)->find($id);
        $reviews = $em->getRepository(Review::class)->findBy(['restaurant' => $restaurant]);

        return $this->render('restaurant_detail.html.twig', [
            'restaurant' => $restaurant,
            'reviews' => $reviews,
        ]);
    }
}
