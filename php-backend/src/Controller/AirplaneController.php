<?php

namespace App\Controller;

use App\Entity\AirplaneType;
use App\Request\AirplaneTypesRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AirplaneController extends AbstractController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/airplanes/types", name="get_airplane_types", methods={"GET"})
     */
    public function getAirplaneTypes(Request $request)
    {
        $params = new AirplaneTypesRequest($request->query->all());

        try {
            $types = $this->getDoctrine()->getRepository(AirplaneType::class)->findAirplaneTypes($params);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
        return new JsonResponse($types, 200);
    }

}
