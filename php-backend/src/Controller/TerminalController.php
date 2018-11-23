<?php

namespace App\Controller;

use App\Entity\Gate;
use App\Entity\Terminal;
use App\Request\TerminalPostRequest;
use App\Request\TerminalsRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

    /**
     * @param TerminalPostRequest $params
     * @param Terminal $user
     * @param UserPasswordEncoderInterface $encoder
     */
    private function setParams(TerminalPostRequest $params, Terminal $user, UserPasswordEncoderInterface $encoder)
    {
        if ($params->name !== null) {
            $user->setName($params->name);
        }

        if ($params->gates !== null && empty($params->gates)) {
            //TBD
        }
    }

    /**
     * @param $id
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     *
     * @Route("/api/terminals/{id}", name="post_terminal", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function postTerminal($id, Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder)
    {
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $terminal = $entityManager->getRepository(Terminal::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse('', 201);
        if ($terminal == null) {
            $response->setStatusCode(404);
            return $response;
        }

        $data = json_decode($request->getContent(), true);
        $params = new TerminalPostRequest($data, false);
        $this->setParams($params, $terminal, $encoder);

        $errors = $validator->validate($terminal);
        if (count($errors) > 0) {
            $apiErrors = [];
            foreach ($errors as $error) {
                $apiErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            $response->setStatusCode(409);
            $response->setData(['errors'=>$apiErrors]);
            return $response;
        }

        try {
            $entityManager->flush();
        } catch (\Exception $exception) {
            $response->setStatusCode(409);
            $response->setData($exception->getMessage());
            return $response;
        }

        $response->setData();
        return $response;
    }
}
