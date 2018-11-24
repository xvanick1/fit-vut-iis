<?php

namespace App\Controller;

use App\Entity\Flight;
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
     * @param Terminal $terminal
     * @throws \Exception
     */
    private function setParams(TerminalPostRequest $params, Terminal $terminal)
    {
        if ($params->name !== null) {
            $terminal->setName($params->name);
        }

        if ($params->deletedGates !== null) { // gate to delete
            foreach ($params->deletedGates as $gate) {
                $tmp = $this->getDoctrine()->getRepository(Gate::class)->findById($gate['id']);
                $flights = $this->getDoctrine()->getRepository(Flight::class)->findByGateId($gate['id']);

                if ($tmp != null && empty($flights)) {
                    $this->getDoctrine()->getManager()->remove($tmp);
                } elseif (!empty($flights)) {
                    throw new \Exception('Exists flights on gate, could not delete.');
                }
            }
        }

        if ($params->gates !== null && !empty($params->gates)) { // check gates (new, changed and unchanged)
            // TBD
            $gates = $terminal->getGates();
            foreach ($params->gates as $gate) {
                if (key_exists('id', $gate)) {
                    // TBD
                } else {
                    $tmp = new Gate();
                    $tmp->setName($gate['name']);
                    $terminal->addGate($tmp);
                }
            }
        }
     }

    /**
     * @param $id
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * @Route("/api/terminals/{id}", name="post_terminal", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function postTerminal($id, Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $terminal = $entityManager->getRepository(Terminal::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse('', 204);
        if ($terminal == null) {
            $response->setStatusCode(404);
            return $response;
        }

        $data = json_decode($request->getContent(), true);
        $params = new TerminalPostRequest($data, false);
        try {
            $this->setParams($params, $terminal);
        } catch (\Exception $exception) {
            $response->setStatusCode(409);
            $response->setData($exception->getMessage());
            return $response;
        }

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
