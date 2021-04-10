<?php

namespace App\Repository;

use App\Entity\Attendence;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Attendence|null find($id, $lockMode = null, $lockVersion = null)
 * @method Attendence|null findOneBy(array $criteria, array $orderBy = null)
 * @method Attendence[]    findAll()
 * @method Attendence[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttendenceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Attendence::class);
    }


    /**
     * @return array[]
     */
    public function getAttendanceMonthlySummary(): array
    {
        //gets Database connection
        $conn = $this->getEntityManager()->getConnection();

        //here applies raw SQL query so each column name should match as it is in Database table (a.mitarbeiter_id_id)
        $sql = '
        SELECT m.vorname, m.nachname, m.rfid_nr,MONTHNAME(STR_TO_DATE(a.date, "%d/%m/%Y")) as month, sum(t.check_out-t.check_in) as hours
        FROM mitarbeiter m, attendence a, timesheet t 
        WHERE m.id=a.mitarbeiter_id_id AND a.id=t.atendance_id_id 
        GROUP BY month, m.id';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }


    /**
     * @return array[]
     */
    public function getAttendanceWeeklySummary(): array
    {
        //gets Database connection
        $conn = $this->getEntityManager()->getConnection();

        //here applies raw SQL query so each column name should match as it is in Database table (a.mitarbeiter_id_id)
        $sql = '
        SELECT m.vorname, m.nachname, m.rfid_nr,WEEK(STR_TO_DATE(a.date, "%d/%m/%Y")) as week, sum(t.check_out-t.check_in) as hours
        FROM mitarbeiter m, attendence a, timesheet t 
        WHERE m.id=a.mitarbeiter_id_id AND a.id=t.atendance_id_id 
        GROUP BY week, m.id';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }


    /**
     * @return array[]
     */
    public function getAttendanceMonthlySummaryByEmployee($mitarbeiter_id): array
    {
        //gets Database connection
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT m.vorname, m.nachname, m.rfid_nr,MONTHNAME(STR_TO_DATE(a.date, "%d/%m/%Y")) as month, sum(t.check_out-t.check_in) as hours
        FROM mitarbeiter m, attendence a, timesheet t 
        WHERE m.id = :mitarbeiter_id AND m.id=a.mitarbeiter_id_id AND a.id=t.atendance_id_id
        GROUP BY month, m.id';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['mitarbeiter_id' => $mitarbeiter_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }

    /**
     * @return array[]
     */
    public function getAttendanceWeeklySummaryByEmployee($mitarbeiter_id): array
    {
        //gets Database connection
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
        SELECT m.vorname, m.nachname, m.rfid_nr,WEEK(STR_TO_DATE(a.date, "%d/%m/%Y")) as week, sum(t.check_out-t.check_in) as hours
        FROM mitarbeiter m, attendence a, timesheet t 
        WHERE m.id = :mitarbeiter_id AND m.id=a.mitarbeiter_id_id AND a.id=t.atendance_id_id 
        GROUP BY week, m.id';
        $stmt = $conn->prepare($sql);
        $stmt->execute(['mitarbeiter_id' => $mitarbeiter_id]);

        // returns an array of arrays (i.e. a raw data set)
        return $stmt->fetchAllAssociative();
    }


    // /**
    //  * @return Attendence[] Returns an array of Attendence objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Attendence
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
