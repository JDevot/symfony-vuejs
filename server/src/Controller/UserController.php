<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\UserRepository;
use App\Repository\TypesRepository;
use App\Repository\VillesRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Exception;
use App\Service\FileUploader;

class UserController extends AbstractController
{

    public function __construct()
    {
    }
    /**
     * @Route("/api/user", name="get_all_user", methods={"GET"})   
     */
    public function getAll(UserRepository $userRepository): JsonResponse
    {
        try {
            $users = $userRepository->findAll();
            $data = [];
            foreach ($users as $user) {
                $data[] = [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'article' => $user->getArticle()
                ];
            }
            return new JsonResponse($data, Response::HTTP_OK);
        } catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/api/user/{id}", name="update_user", methods={"PUT"})
     */
    public function update($id, Request $request, UserRepository $userRepository): JsonResponse
    {
        try {
            $user = $userRepository->findOneBy(['id' => $id]);
            if (!$user) {
                throw new NotFoundHttpException('la post avec l id' . $id . 'n existe pas');
            }
            $data = json_decode($request->getContent(), true);
            empty($data['username']) ? true : $user->setEmail($data['username']);
            $updatedUser = $userRepository->updateUser($user);
            return new JsonResponse($updatedUser->toArray(), Response::HTTP_OK);
        } catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    /**
     * @Route("/api/user/type/{id}", name="search_type", methods={"GET"})
     */
    public function searchType($id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findBy(['id' => $id]);
        return $this->json($user);
    }

    /**
     * @Route("/api/user/{id}", name="delete_user", methods={"DELETE"})
     */
    public function delete($id, UserRepository $userRepository): JsonResponse
    {
        try {
            $user = $userRepository->findOneBy(['id' => $id]);
            if (!$user) {
                throw new NotFoundHttpException('l user avec l id' . $id . 'n existe pas');
            }
            $userRepository->removeUser($user);
            return new JsonResponse(['status' => 'user deleted'], Response::HTTP_NO_CONTENT);
        } catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/api/user/{id}", name="get_one_user", methods={"GET"})   
     */
    public function show($id, UserRepository $userRepository): JsonResponse
    {
        try {
            $user = $userRepository->findOneBy(['id' => $id]);
            $data = [
                'id' => $user->getId(),
                'username' => $user->getUsername(),
                'article' => $user->getArticle()
            ];
            return new JsonResponse($data, Response::HTTP_OK);
        } catch (Exception $err) {
            return new JsonResponse($err, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
