<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Repository\InscriptionsRepository;
use App\Repository\ParticpantRepository;
use App\Repository\SiteRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main")
     */
    public function index(Request $request, SiteRepository $sr, InscriptionsRepository $ir, ParticpantRepository $pr): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        $inscriptions = $ir->findAllwithSortie();
        //dd($this->getUser()->getId());
        $participants = $pr->findSortieById($this->getUser()->getId());
        $sites = $sr->findAll();
        //dd($participants);
        $test = $request->$_GET->;
        dd($test);

        $tab = compact('inscriptions', 'sites', 'participants');
        //$tab = compact('sites');
        return $this->render('main/index.html.twig', $tab);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test(Request $request): Response
    {
        $lieu = new Lieux();
        $formSearch = $this->createForm(LieuxType::class, $lieu);
        $formSearch->handleRequest($request);
        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            dd($lieu);
        }
        return $this->render('main/index.html.twig', [
            'formSearch' => $formSearch->createView(),
        ]);
    }


    /**
     * @Route("/get-code-p/{id}", name="getCode")
     */
    public function getCodeP(Request $request, $id = 0): Response
    {
        $tab = [
            "0" => "error",
            "1" => "44500",
            "3" => "75222",
            "2" => "35500"
        ];
        return $this->json('{"code": ' . $tab[$id] . '}');
    }
}
