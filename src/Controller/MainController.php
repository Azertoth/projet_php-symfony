<?php

namespace App\Controller;

use App\Repository\InscriptionsRepository;
use App\Repository\SortiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(SortiesRepository $sr, InscriptionsRepository $ir): Response
    {
        $inscriptions = $ir->findAllwithSortie();
        //dd($inscriptions);
        $participants = $ir->findAllwithParticipant();
        //$sorties = $sr->findAll();
        //dd($participants);
        $tab = compact('participants', 'inscriptions');
        //$tab = compact('inscriptions');
        return $this->render('main/index.html.twig', $tab);
    }
}
