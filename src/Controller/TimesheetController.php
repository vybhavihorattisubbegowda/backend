<?php

namespace App\Controller;

use App\Entity\Attendence;
use App\Entity\Timesheet; 
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TimesheetController extends AbstractController
{
    
    /**
     * @Rest\Get("/timesheet/{id}", name="timesheet")
     */
    public function getTimesheet(int $id): JsonResponse
    {
        $timesheet = $this->getDoctrine()->getRepository(Timesheet::class)->getTimsheetData($id);
        if (!$timesheet) {
            throw $this->createNotFoundException(
                'No employee data found for id '.$id
            );
        }
        
        return $this->json($timesheet); 
    }

    /**
     * Create timesheet.
     * @Rest\Put("/timesheet", name="put_timesheet")
     * 
     * @return JsonResponse
     */
     //$request is HTTP Request PUT   
     //input is timesheet details as Json 
     public function addTimesheet(Request $request){
        
        //extracting details from JSON object
        $data = json_decode($request->getContent(),false);
      
        $entityManager = $this->getDoctrine()->getManager();
        //$attendance has object (entire row deatil of particular ID) of class Attendence
        $attendance = $entityManager->getRepository(Attendence::class)->find($data->attendance_id);
        
        if(!$attendance){
            throw $this->createNotFoundException('No attendance found for '.$data->attendance_id);
        }

        
        $timesheet = new Timesheet();
        //timestamp comes from Input object and it may be empty so, needs to be checked
        if($data->check_in != ""){
            $timesheet->setCheckIn($data->check_in);
        }
        if($data->check_out != ""){
            $timesheet->setCheckOut($data->check_out);
        }
        //$attendance has object of class Timesheet and can be passed as parameter
        //inside the method it extracts only atendance_id and takes as parameter
        $timesheet->setAtendanceId($attendance); 

        $entityManager->persist($timesheet);
        $entityManager->flush();  
        return new JsonResponse("Created", 201, array(), true);
    }


    /**
     * Create timesheet.
     * @Rest\Post("/timesheet", name="create_timesheet")
     * 
     * @return JsonResponse
     */
     //$request is HTTP Request put   
     //input is timesheet details as Json 
     public function editTimesheet(Request $request){
        
        //extracting details from JSON object
        $data = json_decode($request->getContent(),false);
      
        $entityManager = $this->getDoctrine()->getManager();
 

        $timesheet = $entityManager->getRepository(Timesheet::class)->find($data->id);

        if(!$timesheet){
            throw $this->createNotFoundException('No timesheet found for '.$data->id);
        }

        //Create object of Attendance class
        if($data->check_in!=""){
            $timesheet->setCheckIn($data->check_in);
        }
        if($data->check_out!=""){
        $timesheet->setCheckOut($data->check_out);
        }

        $entityManager->persist($timesheet);
        $entityManager->flush();  
        return new JsonResponse("Updated", 201, array(), true);
    }


}
