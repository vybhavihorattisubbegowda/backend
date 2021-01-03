<?php

namespace App\Controller;

use App\Entity\Delivery;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;


class DeliveryController extends AbstractController
{
    /**
     * @Route("/delivery", name="delivery")
     */
    public function index(): JsonResponse
    {
        $deliveries = $this->getDoctrine()->getRepository(Delivery::class)->findAll();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];
        $normalizer =   new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        
        $serializer = new Serializer([$normalizer], [$encoder]);
        $deliveries_json = $serializer->serialize($deliveries, 'json');
        return new JsonResponse($deliveries_json, 200, array(), true); 
    }
}
