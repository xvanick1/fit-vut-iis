<?php

namespace App\Controller;

use App\Entity\Airplane;
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
     * @Route("/api/airplanes", name="get_airplanes", methods={"GET"})
     */
    public function getAirplaneTypes(Request $request)
    {
        //$params = new AirplaneTypesRequest($request->query->all());

        try {
            $airplanes = $this->getDoctrine()->getRepository(Airplane::class)->findAirplanes();
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $apiAirplanes = [];
        foreach ($airplanes as $airplane) {
            $apiAirplanes[] = [
                'id' => $airplane['id'],
                'crewNumber' => $airplane['crewNumber'],
                'dateOfProduction' => $airplane['dateOfProduction'],
                'dateOfRevision' => $airplane['dateOfRevision'],
                'type' => [
                    'id' => $airplane['atID'],
                    'name' => $airplane['atName']
                ]
            ];
        }

        return new JsonResponse($apiAirplanes, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/airplanes/{id}", name="delete_airplane", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteAirplane($id){
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $airplane = $entityManager->getRepository(Airplane::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        if (!$airplane) {
            return new JsonResponse(null, 404);
        }

        $response = new JsonResponse(null, 204);
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($airplane);
            $entityManager->flush();
        } catch (\Exception $exception) {
            $response->setStatusCode(500);
            $response->setData($exception->getMessage());
            return $response;
        }

        return $response;
    }
}
