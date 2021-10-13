<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function index(): Response
    {
        return $this->render('user/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }


    /**
     * @Route("/detail/{id}", name="user_detail")
     */
    public function detailUser(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException("Cet utilisateur n'existe pas!");
        }
        return $this->render('/detailUser.html.twig', [
            "user" => $user
        ]);
    }
}
