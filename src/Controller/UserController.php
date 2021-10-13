<?php

namespace App\Controller;

use App\Repository\ParticpantRepository;
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
     * @Route("/detail", name="user_detail")
     */
    public function detailUser(ParticpantRepository $uRepository): Response
    {
        $user = $uRepository->find(1);
       
        // if (!$user) {
        //     throw $this->createNotFoundException("Cet utilisateur n'existe pas!");
        // }
        return $this->render('user/detail.html.twig');
    }
}
