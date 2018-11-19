<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Request\FlightsRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
     * @Route("/api/flights", name="get_flights")
     */
    public function getFlights(Request $request)
    {
        $params = new FlightsRequest($request->query->all());
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $flights = $this->getDoctrine()->getRepository(Flight::class)->findFlighs($params);
        $response->setData($flights);

        return $response;
    }

    /**
     * @param Flight $id
     * @return JsonResponse
     *
     * @Route("/api/flights/{id}", name="get_flight")
     */
    public function getFlight($id)
    {
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');
        try {
            $flights = $this->getDoctrine()->getRepository(Flight::class)->findOneBy(["id" => $id]);
        } catch (\Exception $e) {
            throw new HttpException(500, $e->getMessage());
        }

        if ($flights == null) {
            $response->setStatusCode(404);
        } else {
            $response->setData($flights);
        }

        return $response;
    }
}
