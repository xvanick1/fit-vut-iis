<?php

namespace App\Controller;

use App\Entity\User;
use App\Request\UserPostRequest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserController
 * @package App\Controller
 *
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/api/users", name="get_users", methods={"GET"})
     */
    public function getAppUsers()
    {
        try {
            $flights = $this->getDoctrine()->getRepository(User::class)->findUsers(\Doctrine\ORM\Query::HYDRATE_ARRAY);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse();
        $response->setData($flights);

        return $response;
    }

    /**
     * @Route("/api/users/roles", name="get_roles", methods={"GET"})
     */
    public function getRoles()
    {
        $roles = [];
        $roles[] = ['id' => 'ROLE_USER'];
        $roles[] = ['id' => 'ROLE_ADMIN'];
        $roles[] = ['id' => 'ROLE_MANAGER'];

        $response = new JsonResponse();
        $response->setData($roles);

        return $response;
    }

    /**
     * @param User $id
     * @return JsonResponse
     *
     * @Route("/api/users/{id}", name="get_user", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function getAppUser($id)
    {
        try {
            $user = $this->getDoctrine()->getRepository(User::class)->findById($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse();
        if ($user == null) {
            $response->setStatusCode(404);
        } else {
            $response->setData($user);
        }

        return $response;
    }

    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     *
     * @Route("/api/users", name="create_user", methods={"POST"})
     */
    public function createUser(Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder)
    {
        $data = json_decode($request->getContent(), true);
        $params = new UserPostRequest($data, true);

        $user = new User();
        $this->setParams($params, $user);

        $response = new JsonResponse();
        $errors = $validator->validate($user);
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
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        } catch (\Exception $exception) {
            $response->setStatusCode(409);
            $response->setData($exception->getMessage());
            return $response;
        }

        $response->setData();
        return $response;
    }

    /**
     * @param User $id
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param UserPasswordEncoderInterface $encoder
     * @return JsonResponse
     *
     * @Route("/api/users/{id}", name="post_user", methods={"PATCH"}, requirements={"id"="\d+"})
     */
    public function postAppUser($id, Request $request, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder)
    {
        $entityManager = $this->getDoctrine()->getManager();

        try {
            $user = $entityManager->getRepository(User::class)->find($id);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }

        $response = new JsonResponse('', 204);
        if ($user == null) {
            $response->setStatusCode(404);
            return $response;
        }

        $data = json_decode($request->getContent(), true);
        $params = new UserPostRequest($data, false);
        $this->setParams($params, $user);

        $errors = $validator->validate($user);
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

    private function setParams(UserPostRequest $params, User $user)
    {
        if ($params->isActive !== null) {
            $user->setIsActive($params->isActive);
        }

        if ($params->role !== null) {
            $user->setRole($params->role);
        }

        if ($params->surname !== null) {
            $user->setSurname($params->surname);
        }

        if ($params->name !== null) {
            $user->setName($params->name);
        }

        if ($params->username !== null) {
            $user->setUsername($params->username);
        }

        if ($params->password !== null) {
            $password = $encoder->encodePassword($user, $params->password);
            $user->setPassword($password);
        }
    }
}
