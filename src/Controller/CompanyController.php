<?php

namespace App\Controller;

use App\Entity\Company;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class CompanyController extends AbstractController
{
    /**
     * @Route("/company", name="company")
     */
    public function index(): JsonResponse
    {
        $employees = $this->getDoctrine()->getRepository(Company::class)->findAll();
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
     * @Route("/company/{id}", name="get_company")
     */
    public function getCompany(int $id): JsonResponse
    {
        $company = $this->getDoctrine()
            ->getRepository(Company::class)
            ->find($id);
        
       

        if (!$company) {
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
