<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class GateController extends AbstractController
{
    /**
     * @Route("/api/terminals/{id}/gates", name="get_gates", methods={"GET"})
     */
    public function getGates(Request $request)
    {
        //vrati seznam gate pro dany temrinal
        return new JsonResponse();
    }

}
