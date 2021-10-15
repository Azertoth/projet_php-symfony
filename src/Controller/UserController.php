<?php

namespace App\Controller;

use App\Form\ProfilType;
use App\Repository\ParticpantRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{


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
     * @Route("/profilParticipant/{id}", name="profil_participant")
     */
    public function profilPaticipant(ParticpantRepository $participantRepository, $id = 1): Response
    {
        $participant = $participantRepository->find($id);

        if (!$participant) {

            return $this->render('main/login.html.twig');
        }
        return $this->render('user/profilParticipant.html.twig');
    }

    /**
     * @Route("/editProfil", name="edit_profil")
     */
    public function editProfil(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $userForm = $this->createForm(ProfilType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {
            $user = $userForm->getData();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('mon_profil');
        }

        if (!$user) {

            return $this->render('main/login.html.twig');
        }
        return $this->render('user/editProfil.html.twig', [
            'userForm' => $userForm->createView(),
            'user' => $user
        ]);
    }
}
