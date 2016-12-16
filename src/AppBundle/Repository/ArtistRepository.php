<?php
/**
 * Created by PhpStorm.
 * User: renaud
 * Date: 13/12/2016
 * Time: 15:56
 */

namespace AppBundle\Repository;

use AppBundle\Entity\Artist;
use Doctrine\ORM\EntityRepository;

class ArtistRepository extends EntityRepository
{
    public function findAll()
    {
        return $this->findBy([], ['name' => 'ASC']);
    }

    /**
     * @param int $decade
     * @return Artist[]
     */
    public function findByDecade($decade)
    {
        $qb = $this->createQueryBuilder('a');

        $qb->select('a')
            ->where($qb->expr()->between('a.creationYear', ':min', ':max'))
            ->orderBy('a.name', 'ASC')
            ->setParameter('min', $decade)
            ->setParameter('max', $decade + 10);

        return $qb->getQuery()->getResult();
    }
}
