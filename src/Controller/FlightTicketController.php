<?php

namespace App\Controller;


use App\Entity\FlightTicket;
use App\Request\FlightTicketsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FlightTicketController extends AbstractController
{
    /**
     * @param Request $request
     * @return JsonResponse
     *
     * @Route("/api/tickets", name="get_tickets", methods={"GET"})
     */
    public function getTickets(Request $request)
    {
        $params = new FlightTicketsRequest($request->query->all());

        try {
            $tickets = $this->getDoctrine()->getRepository(FlightTicket::class)->findTickets($params);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse();
        $response->setData($tickets);

        return $response;
    }
}
