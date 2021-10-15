<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Form\LieuxType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/lieux", name="lieux_")
 */
class LieuxController extends AbstractController
{
    /**
     * @Route("/create", name="create")
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function add(Request $request,EntityManagerInterface $entityManager): Response
    {
        $lieu =new Lieux();
        $lieuForm = $this->createForm(LieuxType::class,$lieu);
        $lieuForm->handleRequest($request);
        if($lieuForm->isSubmitted() && $lieuForm->isValid()){

            $entityManager->persist($lieu);
            $entityManager->flush();
            $this->addFlash('success','Lieu Créer !' );

            $this->redirectToRoute('lieux_create');

        }
        return $this->render('lieux/lieu.html.twig', [
            'lieuForm' => $lieuForm->createView(),
        ]);
    }
}
