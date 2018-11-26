<?php

namespace App\Controller;

use App\Entity\AirplaneType;
use App\Entity\Gate;
use App\Request\AirplaneTypesRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/airplanes/types/{id}", name="get_airplane_type", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getAirplaneType($id)
    {
        try {
            $airplaneType = $this->getDoctrine()->getRepository(AirplaneType::class)->findById($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse();
        if ($airplaneType == null) {
            $response->setStatusCode(404);
            return $response;
        }

        try {
            $gates = $this->getDoctrine()->getRepository(AirplaneType::class)->findGatesByAirplaneType($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $airplaneType['gates'] = $gates;

        $response->setData($airplaneType);
        return $response;
    }

}
