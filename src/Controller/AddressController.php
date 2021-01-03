<?php

namespace App\Controller;

use App\Entity\Address; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    /**
     * @Route("/address", name="address")
     */
    public function index(): Response
    { 
        $address = $this->getDoctrine()->getRepository(Address::class)->findAll();
        return $this->json($address);
    }

    
     /**
     * @Route("/address/{id}", name="get_address")
     */
    public function getAddress(int $id): Response
    {
        $address = $this->getDoctrine()
            ->getRepository(Address::class)
            ->find($id);

        if (!$address) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return $this->json($address);
        //return new Response('Check out this great product: '.$product->getName());

        // or render a template
        // in the template, print things with {{ product.name }}
        // return $this->render('product/show.html.twig', ['product' => $product]);
    }
}
