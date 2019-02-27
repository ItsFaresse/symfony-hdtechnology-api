<?php

namespace App\Repository;

use App\Entity\Articles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Articles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Articles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Articles[]    findAll()
 * @method Articles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticlesRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Articles::class);
    }

    /**
     * @return Articles[]
     */
    public function findAllVisible(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.visible = false')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Articles[]
     */
    public function findLatest(): array
    {
        return $this->createQueryBuilder('p')
            ->where('p.visible = false ')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
    }


}
