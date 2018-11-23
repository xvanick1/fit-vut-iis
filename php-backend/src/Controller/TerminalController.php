<?php

namespace App\Controller;

use App\Entity\Gate;
use App\Entity\Terminal;
use App\Request\TerminalsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TerminalController extends AbstractController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/terminals", name="get_terminals", methods={"GET"})
     */
    public function getTerminals(Request $request)
    {
        $params = new TerminalsRequest($request->query->all());

        try {
            $terminals = $this->getDoctrine()->getRepository(Terminal::class)->findTerminals($params);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse();
        $response->setData($terminals);

        return $response;
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/terminals/{id}", name="get_terminal", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getTerminal($id)
    {
        try {
            $terminal = $this->getDoctrine()->getRepository(Terminal::class)->findById($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse();
        if ($terminal == null) {
            $response->setStatusCode(404);
            return $response;
        }

        try {
            $gates = $this->getDoctrine()->getRepository(Gate::class)->findByTerminal($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $terminal['gates'] = $gates;
        $response->setData($terminal);

        return $response;
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/terminals/{id}", name="delete_terminal", methods={"DELETE"}, requirements={"id"="\d+"})
     */
    public function deleteTerminal($id){
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $terminal = $entityManager->getRepository(Terminal::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        if (!$terminal) {
            return new JsonResponse(null, 404);
        }

        $response = new JsonResponse(null, 204);
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($terminal);
            $entityManager->flush();
        } catch (\Exception $exception) {
            $response->setStatusCode(500);
            $response->setData($exception->getMessage());
            return $response;
        }

        return $response;
    }
}
