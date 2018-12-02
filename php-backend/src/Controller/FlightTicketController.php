<?php

namespace App\Controller;


use App\Entity\BoardingPass;
use App\Entity\FlightTicket;
use App\Entity\Seat;
use App\Request\FlightTicketPostRequest;
use App\Request\FlightTicketsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

        $apiTickets = [];
        foreach ($tickets as $ticket) {
            $apiTickets[] = [
                'id' => $ticket['id'],
                'name' => $ticket['name'],
                'surname' => $ticket['surname'],
                'flight' => $ticket['flight'],
                'airplaneClass' => $ticket['airplaneClass'],
                'destination' => $ticket['destination'],
                'boardingPass' => $ticket['bid'],
                'seat' => [
                    'id' => $ticket['sid'],
                    'seatNumber' => $ticket['seatNumber']
                ]
            ];
        }

        $response = new JsonResponse();
        $response->setData($apiTickets);

        return $response;
    }

    /**
     * @param $id
     * @return JsonResponse
     *
     * @Route("/api/tickets/{id}/gates", name="get_ticket_gates", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getTicketGates($id)
    {

        try {
            $ticket = $this->getDoctrine()->getRepository(FlightTicket::class)->getById($id);
            $seats = $this->getDoctrine()->getRepository(Seat::class)->findByAirplane($ticket['airplane']);
            $fullSeats = $this->getDoctrine()->getRepository(BoardingPass::class)->getSeatsByFlight($ticket['flight']);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $apiSeats = [];
        foreach ($seats as $seat) {
            if (!in_array($seat['id'], $fullSeats)) {
                $apiSeats[] = [
                    'id' => $seat['id'],
                    'seatNumber' => $seat['seatNumber'],
                    'location' => $seat['location'],
                    'airplaneClass' => [
                        'id' => $seat['acId'],
                        'name' => $seat['acName'],
                    ]
                ];
            }
        }

        $response = new JsonResponse();
        $response->setData($apiSeats);

        return $response;
    }

    /**
     * @param $id
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * @Route("/api/tickets/{id}", name="post_pass", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function postTerminal($id, Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $ticket = $entityManager->getRepository(FlightTicket::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        if ($ticket == null) {
            return new JsonResponse(null, 404);
        }

        $data = json_decode($request->getContent(), true);
        if ($data === null) {
            return new JsonResponse(null, 400);
        }

        $params = new FlightTicketPostRequest($data, true);

        try {
            $seat = $entityManager->getRepository(Seat::class)->find($params->seat);
        } catch (\Exception $e) {
            return new JsonResponse(['errors' => ['orm'=>$e->getMessage()]], 500);
        }

        $boardingPass = new BoardingPass();
        $boardingPass->setName($params->name);
        $boardingPass->setSurname($params->surname);
        $boardingPass->setSeat($seat);

        try {
            $boardingPass->setFlightTicket($ticket);
            $entityManager->persist($boardingPass);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>['orm'=>$exception->getMessage()]], 409);
        }

        return new JsonResponse(null, 204);
    }
}
