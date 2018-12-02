<?php

namespace App\Controller;

use App\Entity\Airplane;
use App\Entity\Flight;
use App\Entity\Gate;
use App\Request\FlightPostRequest;
use App\Request\FlightsRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
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
            return new JsonResponse(['error' => ['orm'=>$e->getMessage()]], 500);
        }

        $response = new JsonResponse();
        if ($flight == null) {
            $response->setStatusCode(404);
        } else {
            $response->setData($flight);
        }

        return $response;
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/flights/{id}", name="delete_flight", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteFlight($id){
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $flight = $entityManager->getRepository(Flight::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        if (!$flight) {
            return new JsonResponse(null, 404);
        }

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($flight);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>['orm'=>$exception->getMessage()]], 409);

        }

        return new JsonResponse(null, 204);
    }

    private function setParams(FlightPostRequest $params, Flight $flight)
    {
        if ($params->destination !== null) {
            $flight->setDestination($params->destination);
        }

        if ($params->dateOfDeparture !== null) {
            $flight->setDateOfDeparture(\DateTime::createFromFormat('Y-m-d', $params->dateOfDeparture));
        }

        if ($params->timeOfDeparture !== null) {
            $flight->setTimeOfDeparture(\DateTime::createFromFormat('H:i', $params->timeOfDeparture));
        }

        if ($params->flightLength !== null) {
            $flight->setFlightLength(\DateTime::createFromFormat('H:i', $params->flightLength));
        }

        if ($params->airplane !== null) {
            $flight->setAirplane($this->getDoctrine()->getRepository(Airplane::class)->find($params->airplane));
        }

        if ($params->gate !== null) {
            $flight->setGate($this->getDoctrine()->getRepository(Gate::class)->find($params->gate));
        }
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws \Exception
     *
     * @Route("/api/flights", name="create_flight", methods={"POST"})
     */
    public function createFlight(Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $flight = new Flight();

        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return new JsonResponse(null, 400);
        }

        $params = new FlightPostRequest($data, true);
        $this->setParams($params, $flight);

        $errors = $validator->validate($flight);
        if (count($errors) > 0) {
            $apiErrors = [];
            foreach ($errors as $error) {
                $apiErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors'=>$apiErrors], 409);
        }

        try {
            $entityManager->persist($flight);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>['orm'=>$exception->getMessage()]], 409);
        }

        return new JsonResponse('', 204);
    }

    /**
     * @param $id
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     * @throws \Exception
     *
     * @Route("/api/flights/{id}", name="update_flight", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function updateFLight($id, Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $flight = $entityManager->getRepository(Flight::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        if ($flight == null) {
            return new JsonResponse(null, 404);
        }

        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return new JsonResponse(null, 400);
        }

        $params = new FlightPostRequest($data, false);
        $this->setParams($params, $flight);

        $errors = $validator->validate($flight);
        if (count($errors) > 0) {
            $apiErrors = [];
            foreach ($errors as $error) {
                $apiErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors'=>$apiErrors], 409);
        }

        try {
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>['orm'=>$exception->getMessage()]], 409);
        }

        return new JsonResponse(null, 204);
    }
}
