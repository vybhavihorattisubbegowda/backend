<?php

namespace App\Repository;

use App\Entity\Timesheet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Timesheet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Timesheet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Timesheet[]    findAll()
 * @method Timesheet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TimesheetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Timesheet::class);
    }

    
    /**
     * @return array[]
     */
    public function getTimsheetData($mitarbeiter_id): array
    {
        //gets Database connection
        $conn = $this->getEntityManager()->getConnection();

        $sql = '	
        SELECT "Kommen" as title, t.id as id,  CONCAT(str_to_date(a.date, "%Y-%m-%d"), " ",  t.check_in) as start, CONCAT(str_to_date(a.date, "%Y-%m-%d"), " ",  AddTime(t.check_in, "00:30")) as end
        FROM timesheet t, attendence a, mitarbeiter m
        where a.id = t.atendance_id_id and m.id = a.mitarbeiter_id_id AND m.id = :mitarbeiter_id
        union
        SELECT  "Gehen" as title, t.id as id,  CONCAT(str_to_date(a.date, "%Y-%m-%d"), " ",  t.check_out)as start, CONCAT(str_to_date(a.date, "%Y-%m-%d"), " ",  AddTime(t.check_out, "00:30")) as end
        FROM timesheet t, attendence a, mitarbeiter m
        where a.id = t.atendance_id_id and m.id = a.mitarbeiter_id_id AND m.id = :mitarbeiter_id
            ';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['mitarbeiter_id' => $mitarbeiter_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }

    // /**
    //  * @return Timesheet[] Returns an array of Timesheet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Timesheet
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
