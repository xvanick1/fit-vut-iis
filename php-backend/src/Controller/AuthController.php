<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AuthController extends AbstractController
{
    /**
     * @Route("/api/auth", name="auth")
     */
    public function index()
    {
        $user = $this->getUser();
        return new JsonResponse(['role'=>$user->getRole()], 200);
    }
}
