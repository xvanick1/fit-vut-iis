<?php

namespace App\Controller;

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
     * @Route("/api/terminals/{id}", name="get_terminal", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getTerminal($id)
    {
        return new JsonResponse();
    }
}
