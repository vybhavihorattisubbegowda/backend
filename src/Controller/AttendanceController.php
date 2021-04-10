<?php

namespace App\Controller;

use App\Entity\Timesheet;
use App\Entity\Attendence; 
use App\Entity\Mitarbeiter;  
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AttendanceController extends AbstractController
{
    /**
     *  @Rest\Get("/attendance", name="attendance")
     */
    public function index(): JsonResponse
    {
        //gets all Employee Attendances from attendance table
        $employeesAttendance = $this->getDoctrine()->getRepository(Attendence::class)->findAll();
        //since Attendance class has reference object of Timesheet class, it needs to be serialized
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];
        $normalizer =   new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $encoder = new JsonEncoder();
        $serializer = new Serializer([$normalizer], [$encoder]);
        $attendance_json = $serializer->serialize($employeesAttendance, 'json');
        return new JsonResponse($attendance_json, 200, array(), true);  
    }

    /**
     *  @Rest\Get("/attendance/{id}", name="get_attendance")
     */
    public function getAttendance(int $id): JsonResponse
    {
        $attendance = $this->getDoctrine()->getRepository(Attendence::class)->find($id);
        
        if (!$attendance) {
            throw $this->createNotFoundException(
                'No Attendance found for id '.$id
            );
        }

        
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];
        $normalizer =   new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        $encoder = new JsonEncoder();
        $serializer = new Serializer([$normalizer], [$encoder]);
        $company_json = $serializer->serialize($attendance, 'json', ['json_encode_options' => JSON_UNESCAPED_SLASHES]);
        
        return new JsonResponse($company_json, 200, array(), true);
         
    }

    /**
     * Create attendance.
     * @Rest\Put("/attendance", name="create_attendance")
     * 
     * @return JsonResponse
     */
     //$request is HTTP Request PUT   
     //input is mitarbeiter details from User Input sent as Json Object
     public function addAttendance(Request $request){
        
        //extracting details from JSON object
        $data = json_decode($request->getContent(),false);
      
        $entityManager = $this->getDoctrine()->getManager();
        //takes user ID as Input & returns matching Object(entire table row), else throws error
        $user = $entityManager->getRepository(Mitarbeiter::class)->find($data->mitarbeiter_id);
        
        if(!$user){
            throw $this->createNotFoundException('No User found for '.$data->mitarbeiter_id);
        }

        //Creates object of Attendance class
        $attendence = new Attendence();
        $attendence->setDate($data->date);
        //$attendence->setStatus($data->status);
        //mitarbeiter object needs to be sent. since we created the reference(FK) objects on both classes
        $attendence->setMitarbeiterId($user); 

        $timesheet = new Timesheet();
        $timesheet->setCheckIn($data->timesheet->check_in);
        $timesheet->setCheckOut($data->timesheet->check_out);
        $attendence->addTimesheet($timesheet);

        $entityManager->persist($attendence);
        $entityManager->flush();  
        return new JsonResponse("Created", 201, array(), true);
    }


    /**
     * @Rest\Get("/attendance/summary/monthly", name="monthly_summary")
     */
    public function monthly_summary(): JsonResponse
    {
        $monthly_summary = $this->getDoctrine()->getRepository(Attendence::class)->getAttendanceMonthlySummary();
        
        return $this->json($monthly_summary); 
    }

     /**
     * @Rest\Get("/attendance/summary/weekly", name="weekly_summary")
     */
    public function weekly_summary(): JsonResponse
    {
        $weekly_summary = $this->getDoctrine()->getRepository(Attendence::class)->getAttendanceWeeklySummary();
        
        return $this->json($weekly_summary); 
    }


    /**
     * @Rest\Get("/attendance/summary/monthly/{id}", name="monthly_summary_by_employee")
     */
    public function monthly_summary_employee(int $id): JsonResponse
    {
        $monthly_summary = $this->getDoctrine()->getRepository(Attendence::class)->getAttendanceMonthlySummaryByEmployee($id);
        
        return $this->json($monthly_summary); 
    }
    
    /**
     * @Rest\Get("/attendance/summary/weekly/{id}", name="weekly_summary_by_employee")
     */
    public function weekly_summary_employee(int $id): JsonResponse
    {
        $weekly_summary = $this->getDoctrine()->getRepository(Attendence::class)->getAttendanceWeeklySummaryByEmployee($id);
        
        return $this->json($weekly_summary); 
    }
 
}
