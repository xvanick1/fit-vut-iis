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

        if ($params->gates !== null && !empty($params->gates)) { // add new gates
            foreach ($params->gates as $gate) {
                if (!key_exists('id', $gate)) {
                    $tmp = new Gate();
                    $tmp->setName($gate['name']);
                    $terminal->addGate($tmp);
                }
            }
        }

        if ($params->updatedGates !== null && !empty($params->updatedGates)) { // add new gates
            $upGates = [];
            foreach ($params->updatedGates as $gate) {
                $upGates[$gate['id']] = $gate['name'];
            }
            $gates = $this->getDoctrine()->getRepository(Gate::class)->findByIds($params->updatedGates);
            foreach ($gates as $gate) {
                $gate->setName($upGates[$gate->getId()]);
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

        $response = new JsonResponse('', 200);
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
            $response->setData(['errors'=>$exception->getMessage()]);
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

        $apiGates = [];
        $gates = $terminal->getGates();
        foreach ($gates as $gate) {
            $apiGates[] = ['id' => $gate->getId(), 'name'=>$gate->getName()];
        }

        $response->setData(['gates'=>$apiGates]);
        return $response;
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @return JsonResponse
     *
     * @Route("/api/terminals", name="create_terminal", methods={"POST"})
     */
    public function createTerminal(Request $request, ValidatorInterface $validator)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $terminal = new Terminal();

        $data = json_decode($request->getContent(), true);
        $params = new TerminalPostRequest($data, true);
        try {
            $this->setParams($params, $terminal);
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>$exception->getMessage()], 409);
        }

        $errors = $validator->validate($terminal);
        if (count($errors) > 0) {
            $apiErrors = [];
            foreach ($errors as $error) {
                $apiErrors[$error->getPropertyPath()] = $error->getMessage();
            }
            return new JsonResponse(['errors'=>$apiErrors], 409);
        }

        try {
            $entityManager->persist($terminal);
            $entityManager->flush();
        } catch (\Exception $exception) {
            return new JsonResponse(['errors'=>$exception->getMessage()], 409);
        }

        $apiGates = [];
        $gates = $terminal->getGates();
        foreach ($gates as $gate) {
            $apiGates[] = ['id' => $gate->getId(), 'name'=>$gate->getName()];
        }

        return new JsonResponse('', 204);
    }

}
