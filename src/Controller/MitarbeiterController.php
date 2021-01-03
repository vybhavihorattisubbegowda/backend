<?php

namespace App\Controller;

use App\Entity\Mitarbeiter;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class MitarbeiterController extends AbstractController
{
    /**
     * @Route("/mitarbeiter", name="mitarbeiter")
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
       return new JsonResponse($employees_json, 200, array(), true);
    }

     /**
     * @Route("/mitarbeiter/{id}", name="get_mitarbeiter")
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
    
}
