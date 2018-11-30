<?php

namespace App\Controller;

use App\Entity\Airplane;
use App\Entity\AirplaneType;
use App\Entity\Seat;
use App\Request\AirplanePostRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AirplaneController extends AbstractController
{

    /**
     * @return JsonResponse
     *
     * @Route("/api/airplanes", name="get_airplanes", methods={"GET"})
     */
    public function getAirplanes()
    {
        try {
            $airplanes = $this->getDoctrine()->getRepository(Airplane::class)->findAirplanes();
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        $apiAirplanes = [];
        foreach ($airplanes as $airplane) {
            $apiAirplanes[] = [
                'id' => $airplane['id'],
                'crewNumber' => $airplane['crewNumber'],
                'dateOfProduction' => $airplane['dateOfProduction'],
                'dateOfRevision' => $airplane['dateOfRevision'],
                'countOfSeats' => $airplane['countOfSeats'],
                'type' => [
                    'id' => $airplane['atID'],
                    'name' => $airplane['atName'],
                    'manufacturer' => $airplane['atManufacturer']
                ]
            ];
        }

        return new JsonResponse($apiAirplanes, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/airplanes/{id}", name="get_airplane", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getAirplane($id)
    {
        try {
            $airplane = $this->getDoctrine()->getRepository(Airplane::class)->findById($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        if ($airplane == null) {
            return new JsonResponse(null, 404);
        }

        try {
            $seats = $this->getDoctrine()->getRepository(Seat::class)->findByAirplane($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        $changedSeats = [];
        foreach ($seats as $seat) {
            $seat['airplaneClass'] = [
                'id' => $seat['acId'],
                'name' => $seat['acName']
            ];
            $changedSeats[] = $seat;
        }

        $airplane['seats'] = $changedSeats;
        $airplane['type'] = [
            'id' => $airplane['atID'],
            'name' => $airplane['atName'],
            'manufacturer' => $airplane['atManufacturer'],
        ];

        return new JsonResponse($airplane);
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
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        if (!$airplane) {
            return new JsonResponse(null, 404);
        }

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($airplane);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>['orm'=>$exception->getMessage()]], 409);

        }

        return new JsonResponse(null, 204);
    }

    private function setParams(AirplanePostRequest $params, Airplane $airplane)
    {
        if ($params->crewNumber !== null) {
            $airplane->setCrewNumber($params->crewNumber);
        }

        if ($params->type !== null) {
            $airplane->setAirplaneType($this->getDoctrine()->getRepository(AirplaneType::class)->find($params->type));
        }

        if ($params->dateOfProduction !== null) {
            $airplane->setDateOfProduction(\DateTime::createFromFormat('Y-m-d', $params->dateOfProduction));
        }

        if ($params->dateOfRevision !== null) {
            $airplane->setDateOfRevision(\DateTime::createFromFormat('Y-m-d', $params->dateOfRevision));
        }
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * @Route("/api/airplanes", name="create_airplane", methods={"POST"})
     */
    public function createAirplane(Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $airplane = new Airplane();

        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return new JsonResponse(null, 400);
        }

        $params = new AirplanePostRequest($data, true);
        $this->setParams($params, $airplane);

        $errors = $validator->validate($airplane);
        if (count($errors) > 0) {
            $apiErrors = [];
            foreach ($errors as $error) {
                $apiErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors'=>$apiErrors], 409);
        }

        try {
            $entityManager->persist($airplane);
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
     *
     * @Route("/api/airplanes/{id}", name="update_airplane", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function updateAirplane($id, Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $airplane = $entityManager->getRepository(Airplane::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        if ($airplane == null) {
            return new JsonResponse(null, 404);
        }

        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return new JsonResponse(null, 400);
        }

        $params = new AirplanePostRequest($data, false);
        $this->setParams($params, $airplane);

        $errors = $validator->validate($airplane);
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
