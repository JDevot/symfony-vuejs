<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class AuthController extends AbstractController
{
    /**
     * @Route("/auth", name="auth")
     */
    public function index(): Response
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/AuthController.php',
        ]);
    }
    /**
     * @Route("/api/login_check", name="login", methods={"POST"})
     */
    public function login(): JsonResponse
    {
            $user = $this->getUser();
            return $this->json(array(
                'id' => $user->getId(),
                'username' => $user->getEmail(),
            ), Response::HTTP_OK);
    }
    /**
     * @Route("/register", name="register", methods={"POST"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder, UserRepository $userRepository)
    {
        try {
            $data = json_decode($request->getContent(), true);
            if (empty($data['username']) || empty($data['password'])) {
                throw new NotFoundHttpException('Expecting mandatory parameters');
            }
            $userInDb = $userRepository->findOneBy(['email' => $data['username']]);
            if ($userInDb){
                return $this->json('error: utilisateur présent dans la db', Response::HTTP_CONFLICT);
            }
            $password = $data['password'];
            $email = $data['username'];
            $user = new User();
            $user->setPassword($encoder->encodePassword($user, $password));
            $user->setEmail($email);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->json('status: created', Response::HTTP_CREATED);
        } catch (Exception $err) {
            return $this->json($err, Response::HTTP_BAD_REQUEST);
        }
    }
}
