<?php

namespace App\Controller;

use App\Entity\Gate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class GateController extends AbstractController
{
    /**
     * @Route("/api/gates", name="get_gates", methods={"GET"})
     */
    public function getGates()
    {
        $apiGates = [];
        $gates = $this->getDoctrine()->getRepository(Gate::class)->findGates();
        foreach ($gates as $gate) {
            $apiGates[] = [
                'id' => $gate['id'],
                'name' => $gate['name'],
                'terminal' => [
                    'id'=> $gate['terminalId'],
                    'name' => $gate['terminalName']
                ]
            ];
        }
        return new JsonResponse($apiGates, 200);
    }

}
