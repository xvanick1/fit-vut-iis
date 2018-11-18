<?php

namespace App\Controller;


use App\Entity\FlightTicket;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FlightTicketController extends AbstractController
{
    /**
     * @Route("/api/tickets", name="get_tickets")
     * @param Request $request
     * @return JsonResponse
     */
    public function getTickets(Request $request)
    {
        $response = new JsonResponse();
        $response->headers->set('Access-Control-Allow-Origin', '*');

        $tickets = $this->getDoctrine()->getRepository(FlightTicket::class)->findAll();
        $response->setData($tickets);

        return $response;
    }
}
