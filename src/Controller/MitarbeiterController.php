<?php

namespace App\Controller;

use App\Entity\Mitarbeiter; 
use App\Services\Api\Serializer\ObjectSerializer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route; 

class MitarbeiterController extends AbstractController
{
    /**
     * @Route("/mitarbeiter", name="mitarbeiter")
     */
    public function index()
    {

       $employees = $this->getDoctrine()->getRepository(Mitarbeiter::class)->findAll();
        // return $this->json($employees);
        $objectSerializer = new ObjectSerializer($employees);

        return new JsonResponse([
                'status' => 'success',
                'employee' => $objectSerializer->serializeObject(),
                ], JsonResponse::HTTP_OK); 
    }
}
