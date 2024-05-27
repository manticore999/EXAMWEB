<?php

namespace App\Repository;

use App\Entity\Restaurants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RestaurantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurants::class);
    }

    // Add custom query methods here if needed
}
