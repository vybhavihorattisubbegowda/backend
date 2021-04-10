<?php

namespace App\Controller;

use App\Entity\Mitarbeiter;  
use App\Entity\Attendence; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\Annotations as Rest;

class MitarbeiterController extends AbstractController{


    /**
     * Lists all employees.
     * @Rest\Get("/mitarbeiter", name="get_mitarbeiter")
     * 
     * @return JsonResponse
     */
    public function getMitarbeiter(): JsonResponse
    {
       //gets all Employees from mitarbeiter table
       $employees = $this->getDoctrine()->getRepository(Mitarbeiter::class)->findAll();
       //since Mitarbeiter class has reference object of Attendance class, it needs to be serialized
       $defaultContext = [
           AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
               return $object;
           },
       ];
       //Normalizer converts specific Array into Object.
       $normalizer =   new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
       $encoder = new JsonEncoder();
       $serializer = new Serializer([$normalizer], [$encoder]);
       $employees_json = $serializer->serialize($employees, 'json');
       //returns a new JSON object out of an Array after Serialization
       return new JsonResponse($employees_json, 200, array(), true);
    }

    
     /**
     * @Rest\Get("/v2/mitarbeiters", name="employees")
     */
    public function summary(): JsonResponse
    {
        $order_summary = $this->getDoctrine()->getRepository(Mitarbeiter::class)->getEmployees();
        return $this->json($order_summary); 
    }

     
    
    /**
     * List employee by ID.
     * @Rest\Get("/mitarbeiter/{id}", name="get_mitarbeiter_Id")
     * 
     * @return JsonResponse
     */
    public function getMitarbeiterById(int $id): JsonResponse
    {
        //gets particular Employee by ID from mitarbeiter table
        $employee = $this->getDoctrine()->getRepository(Mitarbeiter::class)->find($id);
        
        if (!$employee) {
            throw $this->createNotFoundException(
                'No employee found for id '.$id
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
        $employee_json = $serializer->serialize($employee, 'json', ['json_encode_options' => JSON_UNESCAPED_SLASHES]);
        
        return new JsonResponse($employee_json, 200, array(), true);
     
    }

    /**
     * Insert employee.
     * @Rest\Put("/mitarbeiter", name="insert_mitarbeiter")
     * 
     * @return JsonResponse
     */
     //$request is HTTP Request PUT   
     //input is mitarbeiter details from a Form sent as Json Object
     public function addMitarbeiter(Request $request){
        
        //extracting details from JSON object
        //with false parameter the incoming JSON Object remains as Object and allows -> operator
        //with true parameter incoming JSON Object turns into Array 
        $data = json_decode($request->getContent(),false);
        
        //Create object of Mitarbeiter Class/Entity
        $mitarbeiter = new Mitarbeiter();
        $mitarbeiter->setNachname($data->lastName);
        $mitarbeiter->setVorname($data->firstName);
        $mitarbeiter->setEmail($data->email);
        $mitarbeiter->setPasswort($data->password);
        $mitarbeiter->setRolle($data->role);
        $mitarbeiter->setRfidNr($data->rfid_nr);

        //Saving to Database happens
        $em = $this->getDoctrine()->getManager();
        //Preparing to Save
        $em->persist($mitarbeiter);
        //will be Saved
        $em->flush();  
        return new JsonResponse("Created", 201, array(), true);
    }

    /**
     * Update employee.
     * @Rest\Post("/mitarbeiter", name="update_mitarbeiter")
     * 
     * @return JsonResponse
     */
     //$request is HTTP Request POST   
     //input is mitarbeiter details from User Input sent as Json Object 
     public function updateMitarbeiter(Request $request){
        
        //extracting details from JSON object
        $data = json_decode($request->getContent(),false);

        $entityManager = $this->getDoctrine()->getManager();
        //Before updating confirm with the ID
        $mitarbeiter = $entityManager->getRepository(Mitarbeiter::class)->find($data->id);
        //handle Exception if ID not exists
        if(!$mitarbeiter){
            throw $this->createNotFoundException('No User found for '.$data->id);
        }

        $mitarbeiter->setNachname($data->lastName);
        $mitarbeiter->setVorname($data->firstName);
        $mitarbeiter->setEmail($data->email);
        $mitarbeiter->setPasswort($data->password);
        $mitarbeiter->setRolle($data->role);
        $mitarbeiter->setRfidNr($data->rfid_nr);

        $entityManager->persist($mitarbeiter);
        $entityManager->flush();  
        return new JsonResponse("Updated", 201, array(), true);
    }
    

    /**
     * delete employee.
     * @Rest\Delete("/mitarbeiter/{id}", name="delete_mitarbeiter")
     * 
     * @return JsonResponse
     */
      
     //input is mitarbeiter id 
     public function deleteMitarbeiter(int $id){
        
        $entityManager = $this->getDoctrine()->getManager();

        $mitarbeiter = $entityManager->getRepository(Mitarbeiter::class)->find($id);
        
        if(!$mitarbeiter){
            throw $this->createNotFoundException('No User found for');
        }
        $entityManager->remove($mitarbeiter);
        $entityManager->flush();  
        return new JsonResponse("deleted", 201, array(), true);
    }


    /**
     *  @Rest\Post("/mitarbeiter/update/password", name="update_password")
     */
    public function update_password(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(),false);
        
        $this->getDoctrine()->getRepository(Mitarbeiter::class)->updatePassword($data->email, $data->password);
      
        return new JsonResponse("Updated", 201, array(), true);
    }

     /**
     * @Rest\Get("/attendance/summary/monthly/{id}", name="monthly_summary_by_employee")
     */
    public function monthly_summary_employee(int $id): JsonResponse
    {
        $monthly_summary = $this->getDoctrine()->getRepository(Attendence::class)->getAttendanceMonthlySummaryByEmployee($id);
        
        return $this->json($monthly_summary); 
    }

}
