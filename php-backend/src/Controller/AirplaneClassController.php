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

class AirplaneClassController extends AbstractController
{
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
}
