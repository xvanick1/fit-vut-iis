<?php

namespace App\Controller;

use App\Entity\AirplaneClass;
use App\Request\AirplaneClassesRequest;
use SensioLabs\Security\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class AirplaneClassController extends AbstractController
{
    /**
     * @return JsonResponse
     *
     * @Route("/api/airplanes/classes/all", name="get_all_airplane_classes", methods={"GET"})
     */
    public function getAllAirplaneClasses()
    {
        try {
            $airplaneClasses = $this->getDoctrine()->getRepository(AirplaneClass::class)->findAllAirplaneClasses();
        } catch (Exception $exception) {
            return new JsonResponse(['errors'=>['request'=>$exception->getMessage()]],500);
        }

        return new JsonResponse($airplaneClasses, 200);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/airplanes/classes", name="get_airplane_classes", methods={"GET"})
     */
    public function getAirplaneClasses(Request $request)
    {
        try {
            $params = new AirplaneClassesRequest($request->query->all());
        } catch (HttpException $exception) {
            return new JsonResponse(['errors'=>['request'=>$exception->getMessage()]],400);
        }

        try {
            $airplaneClasses = $this->getDoctrine()->getRepository(AirplaneClass::class)->findAirplaneClasses($params);
        } catch (Exception $exception) {
            return new JsonResponse(['errors'=>['request'=>$exception->getMessage()]],500);
        }

        return new JsonResponse($airplaneClasses, 200);
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/airplanes/classes/{id}", name="delete_airplane_class", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteAirplane($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $airplaneClass = $entityManager->getRepository(AirplaneClass::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        if (!$airplaneClass) {
            return new JsonResponse(null, 404);
        }

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($airplaneClass);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>['orm'=>$exception->getMessage()]], 409);

        }

        return new JsonResponse(null, 204);
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * @Route("/api/airplanes/classes", name="create_airplane_class", methods={"POST"})
     */
    public function createAirplaneClass(Request $request, ValidatorInterface $validator)
    {
        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return new JsonResponse(null, 400);
        } elseif (!is_array($data) || !key_exists('name', $data)) {
            return new JsonResponse($data, 400);
        } elseif (!is_string($data['name'])) {
            return new JsonResponse('Bad request: name is not string', 409);
        }

        $airplaneClass = new AirplaneClass();
        $airplaneClass->setName($data['name']);

        $errors = $validator->validate($airplaneClass);
        if (count($errors) > 0) {
            $apiErrors = [];
            foreach ($errors as $error) {
                $apiErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors'=>$apiErrors], 409);
        }

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($airplaneClass);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>['orm'=>$exception->getMessage()]], 409);
        }

        return new JsonResponse(['id'=>$airplaneClass->getId()], 201);
    }

    /**
     * @param $id
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * @Route("/api/airplanes/classes/{id}", name="update_airplane_class", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function updateAirplaneClass($id, Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return new JsonResponse(null, 400);
        } elseif (!is_array($data) || !key_exists('name', $data)) {
            return new JsonResponse($data, 400);
        } elseif (!is_string($data['name'])) {
            return new JsonResponse('Bad request: name is not string', 409);
        }

        try {
            $airplaneClass = $entityManager->getRepository(AirplaneClass::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        if (!$airplaneClass) {
            return new JsonResponse(null, 404);
        }

        $airplaneClass->setName($data['name']);

        $errors = $validator->validate($airplaneClass);
        if (count($errors) > 0) {
            $apiErrors = [];
            foreach ($errors as $error) {
                $apiErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors'=>$apiErrors], 409);
        }

        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>['orm'=>$exception->getMessage()]], 409);

        }

        return new JsonResponse(null, 204);
    }
}
