<?php

namespace App\Repository;

use App\Entity\BlogPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BlogPost>
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    //    /**
    //     * @return BlogPost[] Returns an array of BlogPost objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('b.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?BlogPost
    //    {
    //        return $this->createQueryBuilder('b')
    //            ->andWhere('b.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
    public function findLatest()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.publishedAt', 'DESC')
            ->andWhere('b.publishedAt is NOT NULL ')
            ->setMaxResults(1)
            ->getQuery()->getOneOrNullResult();

    }

    public function findPublished(int $limit = 5, int $currentPage = 0, string $tag = null)
    {
        $qb = $this->createQueryBuilder('b')
            ->orderBy('b.publishedAt', 'DESC')
            ->andWhere('b.publishedAt is NOT NULL ');
        if ($tag) {
            $qb = $qb->andWhere('b.tags LIKE :tag')
                ->setParameter('tag', '%' . $tag . '%');
        }
        return $qb->setFirstResult($currentPage * $limit)
            ->setMaxResults($limit)
            ->getQuery()->getResult();
    }

    public function countPublished(string $tag = null)
    {
        $qb = $this->createQueryBuilder('b')
            ->select('COUNT(b)');
        if ($tag) {
            $qb = $qb->andWhere('b.tags LIKE :tag')
                ->setParameter('tag', '%' . $tag . '%');
        }


        return $qb->andWhere('b.publishedAt is NOT NULL ')->getQuery()->getSingleScalarResult();
    }
}
