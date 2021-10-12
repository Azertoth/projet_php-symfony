<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\UserDetailType;
use App\Repository\ParticipantsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/user/detail/{id}", name="detail") 
     */
    public function detail(Request $request, ParticipantsRepository $pr, $id = 1): Response
    {
        $participant = $pr->find($id);
        $form = $this->createForm(UserDetailType::class, $participant);
        $form->handleRequest($request);
        $detailForm = $form->createView();
        $tab = compact("participant", "detailForm");
        $tab["key"] = "value";

        if ($form->isSubmitted() && $form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($participant);
            $em->flush();

            return $this->redirectToRoute('detail');
        }


        return $this->render('user/detail.html.twig', $tab);
    }
}
