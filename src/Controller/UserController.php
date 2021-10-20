<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Form\ProfilType;
use App\Repository\InscriptionsRepository;
use App\Repository\ParticpantRepository;
use App\Repository\SortiesRepository;
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
    public function profilPaticipant(int $id, ParticpantRepository $pr): Response
    {
        $user = $pr->findOneById($id);
        //dd($user);

        if (!$user) {

            return $this->render('main/login.html.twig');
        }
        $tab = compact('user');
        return $this->render('user/profilParticipant.html.twig', $tab);
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

    /**
     * @Route("/inscrire/{id}", name="inscrire")
     */
    public function inscrire(EntityManagerInterface $em, SortiesRepository $sr, $id): Response
    {
        $date = new \DateTime('now');
        $sortie = $sr->findOneById($id);
        $user = $this->getUser();
        $inscription = new Inscriptions;
        $inscription->setParticipants($user);
        $inscription->setSortie($sortie);
        $inscription->setDateInscription($date);

        $em->persist($inscription);
        $em->flush();
        return $this->redirectToRoute('main');
    }

    /**
     * @Route("/desinscrire/{id}", name="desinscrire")
     */
    public function desinscrire(InscriptionsRepository $ir, EntityManagerInterface $em, SortiesRepository $sr, $id): Response
    {
        
        $sortie = $sr->findOneById($id);
        $user = $this->getUser();
        $inscription = $ir->delete($sortie, $user);
        $em->remove($inscription);
        $em->flush();
        
        return $this->redirectToRoute('main');
    }

}
