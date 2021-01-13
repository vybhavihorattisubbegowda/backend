<?php

namespace App\Controller;

use App\Entity\Mitarbeiter;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer; 
use FOS\RestBundle\Controller\Annotations as Rest;

class MitarbeiterController extends AbstractController
{
    /**
     * Lists all employees.
     * @Rest\Get("/mitarbeiter")
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {

       $employees = $this->getDoctrine()->getRepository(Mitarbeiter::class)->findAll();
       $encoder = new JsonEncoder();
       $defaultContext = [
           AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
               return $object;
           },
       ];
       $normalizer =   new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
       
       $serializer = new Serializer([$normalizer], [$encoder]);
       $employees_json = $serializer->serialize($employees, 'json');
       return new JsonResponse($employees_json, 200, array(), true);//returns new object of Json
    }

     /**
     * Lists all employees.
     * @Rest\Get("/mitarbeiter/{id}")
     * 
     * @return JsonResponse
     */
    public function getMitarbeiter(int $id): JsonResponse
    {
        $employee = $this->getDoctrine()
            ->getRepository(Mitarbeiter::class)
            ->find($id);
        
       

        if (!$employee) {
            throw $this->createNotFoundException(
                'No employee found for id '.$id
            );
        }

        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];
        $normalizer =   new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
       
        $serializer = new Serializer([$normalizer], [$encoder]);
        $employee_json = $serializer->serialize($employee, 'json', ['json_encode_options' => JSON_UNESCAPED_SLASHES]);
        
        return new JsonResponse($employee_json, 200, array(), true);
        //return $this->json($employee);
        //return new Response('Check out this great product: '.$product->getName()); 
    }

    /**
     * Create employee.
     * @Rest\Post("/mitarbeiter")
     * 
     * @return JsonResponse
     */
    //$request is HTTP Request - POST   
     public function postMitarbeiterAction(Request $request){//input is a mitarbeiter details as Json 
        
        $data = json_decode($request->getContent(),true);//extracting details from object
        
        $mitarbeiter = new Mitarbeiter();//Entity class constructor 
        $mitarbeiter->setNachname($data["lastName"]);
        $mitarbeiter->setVorname($data["firstName"]);
        $mitarbeiter->setEmail($data["email"]);
        $mitarbeiter->setPasswort($data["password"]);

        $em=$this->getDoctrine()->getManager();
        $em->persist($mitarbeiter);
        $em->flush();  
        return new JsonResponse("Created", 201, array(), true);
    }
    
}
