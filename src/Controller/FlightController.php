<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Request\FlightsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;

class FlightController extends AbstractController
{
    /**
     * @Route("/api/flights", name="get_flights")
     */
    public function getFlights(Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_MANAGER");
        $params = new FlightsRequest($request->query->all());
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $flights = $this->getDoctrine()->getRepository(Flight::class)->findAll();
        $response->setData($flights);

        return $response;
    }

    /**
     * @Route("/api/flights/{id}", name="get_flight")
     * @param Flight $id
     * @return JsonResponse
     */
    protected function getFlight(Flight $id)
    {
        $this->denyAccessUnlessGranted("ROLE_MANAGER");
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        try {
            $flights = $this->getDoctrine()->getRepository(Flight::class)->findOneBy(["id" => $id]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }
        $response->setData($flights);

        return $response;
    }
}
