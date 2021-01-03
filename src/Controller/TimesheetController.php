<?php

namespace App\Controller;

use App\Entity\Timesheet; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TimesheetController extends AbstractController
{
    /**
     * @Route("/timesheet", name="timesheet")
     */
    public function index(): Response
    {
        return $this->render('timesheet/index.html.twig', [
            'controller_name' => 'TimesheetController',
        ]);
    }
}
