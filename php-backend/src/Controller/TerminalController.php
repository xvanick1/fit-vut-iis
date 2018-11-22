<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TerminalController extends AbstractController
{
    /**
     * @Route("/api/terminals", name="get_terminals", methods={"GET"})
     */
    public function getTerminals()
    {
        return new JsonResponse();
    }

    /**
     * @Route("/api/terminals/{id}", name="get_terminal", methods={"GET"})
     */
    public function getTerminal($id)
    {
        return new JsonResponse();
    }
}
