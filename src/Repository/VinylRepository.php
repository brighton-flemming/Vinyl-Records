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

    public function search($query)
    {
        return $this->createQueryBuilder('v')
            ->where('v.record_name LIKE :query OR v.artist_name LIKE :query')
            ->setParameter('query', '%'.$query.'%')
            ->getQuery()
            ->getResult();
    }

    // src/Repository/VinylRepository.php

    public function findOneByRecordSequence($record_sequence): ?Vinyl
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.record_sequence = :record_sequence')
            ->setParameter('record_sequence', $record_sequence)
            ->getQuery()
            ->getOneOrNullResult();
    }


}
