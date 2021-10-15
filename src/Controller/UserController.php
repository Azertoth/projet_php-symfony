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
        return $this->render('security/login.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/monProfil", name="mon_profil")
     */
    public function monProfil(): Response
    {
        $user = $this->getUser();

        if (!$user) {

            return $this->render('main/login.html.twig');
        }
        return $this->render('user/monProfil.html.twig');
    }
    /**
     * @Route("/profilParticipant", name="profil_participant")
     */
    public function profilPaticipant(): Response
    {
        $user = $this->getUser();

        if (!$user) {

            return $this->render('main/login.html.twig');
        }
        return $this->render('user/profilParticipant.html.twig');
    }

    /**
     * @Route("/editProfil", name="edit_profil")
     */
    public function editProfil(): Response
    {
        $user = $this->getUser();

        if (!$user) {

            return $this->render('main/login.html.twig');
        }
        return $this->render('user/editProfil.html.twig');
    }
}
