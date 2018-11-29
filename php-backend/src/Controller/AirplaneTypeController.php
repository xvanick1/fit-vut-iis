<?php

namespace App\Controller;

use App\Entity\AirplaneType;
use App\Entity\Gate;
use App\Request\AirplaneTypePostRequest;
use App\Request\AirplaneTypesRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AirplaneTypeController extends AbstractController
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
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
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
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        $response = new JsonResponse();
        if ($airplaneType == null) {
            $response->setStatusCode(404);
            return $response;
        }

        try {
            $gates = $this->getDoctrine()->getRepository(AirplaneType::class)->findGatesByAirplaneType($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        $airplaneType['gates'] = $gates;

        $response->setData($airplaneType);
        return $response;
    }

    /**
     * @param AirplaneTypePostRequest $params
     * @param AirplaneType $airplaneType
     */
    private function setParams(AirplaneTypePostRequest $params, AirplaneType $airplaneType)
    {
        if ($params->name !== null) {
            $airplaneType->setName($params->name);
        }

        if ($params->manufacturer !== null) {
            $airplaneType->setManufacturer($params->manufacturer);
        }

        if ($params->gates !== null && !empty($params->gates)) {
            $gates = $this->getDoctrine()->getRepository(Gate::class)->findByIds($params->gates);
            foreach ($gates as $gate) {
                $airplaneType->addGate($gate);
            }
        }

        if ($params->deletedGates !== null && !empty($params->deletedGates)) {
            $gates = $this->getDoctrine()->getRepository(Gate::class)->findByIds($params->deletedGates);
            foreach ($gates as $gate) {
                $airplaneType->removeGate($gate);
            }
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * @Route("/api/airplanes/types/{id}", name="post_airplane_type", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function postAirplaneType($id, Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $airplaneType = $entityManager->getRepository(AirplaneType::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        $response = new JsonResponse('', 204);
        if ($airplaneType == null) {
            $response->setStatusCode(404);
            return $response;
        }

        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return new JsonResponse(null, 400);
        }

        $params = new AirplaneTypePostRequest($data, false);
        $this->setParams($params, $airplaneType);

        $errors = $validator->validate($airplaneType);
        if (count($errors) > 0) {
            $apiErrors = [];
            foreach ($errors as $error) {
                $apiErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            $response->setStatusCode(409);
            $response->setData(['errors'=>$apiErrors]);
            return $response;
        }

        try {
            $entityManager->flush();
        } catch (\Exception $exception) {
            $response->setStatusCode(409);
            $response->setData(['errors'=>['orm'=>$exception->getMessage()]]);
            return $response;
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * @Route("/api/airplanes/types", name="create_airplane_type", methods={"POST"})
     */
    public function createAirplaneType(Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $airplaneType = new AirplaneType();

        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return new JsonResponse(null, 400);
        }

        $params = new AirplaneTypePostRequest($data, true);
        $this->setParams($params, $airplaneType);


        $errors = $validator->validate($airplaneType);
        if (count($errors) > 0) {
            $apiErrors = [];
            foreach ($errors as $error) {
                $apiErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors'=>$apiErrors], 409);
        }

        try {
            $entityManager->persist($airplaneType);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>['orm'=>$exception->getMessage()]], 409);
        }

        return new JsonResponse('', 204);
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/airplanes/types/{id}", name="delete_airplane_type", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteAirplaneType($id){
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $airplaneType = $entityManager->getRepository(AirplaneType::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        if (!$airplaneType) {
            return new JsonResponse(null, 404);
        }

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($airplaneType);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>['orm'=>$exception->getMessage()]], 409);
        }

        return new JsonResponse(null, 204);
    }
}
