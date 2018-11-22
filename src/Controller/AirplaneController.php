<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AirplaneController extends AbstractController
{
    /**
     * @Route("/api/airplanes/types", name="get_airplane_types", methods={"GET"})
     */
    public function getAirplaneTypes()
    {
        return new JsonResponse();
    }

}
