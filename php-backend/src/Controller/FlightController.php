<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Request\FlightsRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class FlightController
 * @package App\Controller
 *
 * @IsGranted("ROLE_MANAGER")
 */
class FlightController extends AbstractController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/flights", name="get_flights", methods={"GET"})
     */
    public function getFlights(Request $request)
    {
        $params = new FlightsRequest($request->query->all());

        try {
            $flights = $this->getDoctrine()->getRepository(Flight::class)->findFlighs($params);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse();
        $response->setData($flights);

        return $response;
    }

    /**
     * @param Flight $id
     * @return JsonResponse
     *
     * @Route("/api/flights/{id}", name="get_flight", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getFlight($id)
    {
        try {
            $flight = $this->getDoctrine()->getRepository(Flight::class)->findById($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse();
        if ($flight == null) {
            $response->setStatusCode(404);
        } else {
            $response->setData($flight);
        }

        return $response;
    }
}
