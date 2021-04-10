<?php

namespace App\Repository;

use App\Entity\Mitarbeiter;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mitarbeiter|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mitarbeiter|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mitarbeiter[]    findAll()
 * @method Mitarbeiter[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MitarbeiterRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mitarbeiter::class);
    }

    /**
     * @return array[]
     */
    public function getEmployees(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT *
        FROM `mitarbeiter`';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (returns array of objects(object means one entire row of SQL Table))
        return $stmt->fetchAllAssociative();
    }


    /**
     * @return array[]
     */
    public function login($email, $password): array
    {

        $qb = $this->createQueryBuilder('p')
            ->select(array('p.vorname, p.nachname, p.email'))
            ->where('p.email = :email')
            ->andWhere('p.passwort = :password')
            ->setParameters(array('email' => $email, 'password' => $password));

        $query = $qb->getQuery();

        return $query->execute();
    }

   
    public function updatePassword($email, $password)
    {
        
        //gets Database connection
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        UPDATE mitarbeiter
        SET passwort = :password
        WHERE email = :email';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['password' => $password, 'email'=>$email]);
    }


    // /**
    //  * @return Mitarbeiter[] Returns an array of Mitarbeiter objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Mitarbeiter
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
