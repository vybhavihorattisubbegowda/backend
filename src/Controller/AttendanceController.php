<?php

namespace App\Controller;

use App\Entity\Attendence; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class AttendanceController extends AbstractController
{
    /**
     * @Route("/attendance", name="attendance")
     */
    public function index(): JsonResponse
    {
        $employeesAttendance = $this->getDoctrine()->getRepository(Attendence::class)->findAll();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];
        $normalizer =   new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        
        $serializer = new Serializer([$normalizer], [$encoder]);
        $attendance_json = $serializer->serialize($employeesAttendance, 'json');
        return new JsonResponse($attendance_json, 200, array(), true);  
    }

    /**
     * @Route("/attendance/{id}", name="get_attendance")
     */
    public function getAttendance(int $id): JsonResponse
    {
        $attendance = $this->getDoctrine()
            ->getRepository(Attendence::class)
            ->find($id);
        
       

        if (!$attendance) {
            throw $this->createNotFoundException(
                'No company found for id '.$id
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
        $company_json = $serializer->serialize($company, 'json', ['json_encode_options' => JSON_UNESCAPED_SLASHES]);
        
        return new JsonResponse($company_json, 200, array(), true);
         
    }
}
