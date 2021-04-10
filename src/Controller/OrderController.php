<?php

namespace App\Controller;

use App\Entity\Orders;  
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

class OrderController extends AbstractController
{
    /**
     * @Route("/orders", name="orders")
     */
    public function index(): JsonResponse
    {
        $orders = $this->getDoctrine()->getRepository(Orders::class)->findAll();
        $encoder = new JsonEncoder();
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object;
            },
        ];
        $normalizer =   new ObjectNormalizer(null, null, null, null, null, null, $defaultContext);
        
        $serializer = new Serializer([$normalizer], [$encoder]);
      
        $orders_json = $serializer->serialize($orders, 'json');
        return new JsonResponse($orders_json, 200, array(), true); 
    }

    /**
     * @Route("/orders/summary", name="summary")
     */
    public function summary(): JsonResponse
    {
        $order_summary = $this->getDoctrine()->getRepository(Orders::class)->getOrderSummary();
        
        return $this->json($order_summary); 
    }
}
