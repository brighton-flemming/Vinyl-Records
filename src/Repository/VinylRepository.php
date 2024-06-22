<?php

namespace App\Repository;

use App\Entity\Vinyl;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vinyl>
 */

class VinylRepository extends ServiceEntityRepository
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Vinyl::class);
    }

    public function findMaxId(): ?int
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT MAX(e.id)
            FROM App\Entity\Vinyl e'
        );

        return $query->getSingleScalarResult();
    }

}
