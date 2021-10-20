<?php

namespace App\Controller;

use App\Repository\LieuxRepository;
use App\Repository\SortiesRepository;
use App\Repository\VillesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiFiltrerController extends AbstractController
{
    /**
     * @Route("/api/sortie-lieu-ville", name="api")
     */
    public function api(SortiesRepository $sortiesRepo, LieuxRepository $lieuxRepo, VillesRepository $villeRepo): Response
    {

        $json = [];

        //---------------------API SORTIES----------------------------
        $sorties = $sortiesRepo->findAll();
        $tab_sorties = [];
        foreach ($sorties as $sortie) {
            $info_sortie['id'] = $sortie->getId();
            $info_sortie['etat_id'] = $sortie->getEtat()->getId();
            $info_sortie['lieux_id'] = $sortie->getSite()->getId();
            $info_sortie['site_id'] = $sortie->getSite()->getId();
            $info_sortie['organisateur_id'] = $sortie->getOrganisateur()->getId();
            $info_sortie['nom_sortie'] = $sortie->getNomSortie();
            $info_sortie['date_heure_debut'] = $sortie->getDateHeureDebut();
            $info_sortie['duree'] = $sortie->getDuree();
            $info_sortie['date_limit_inscription'] = $sortie->getDateLimiteInscription();
            $info_sortie['nb_inscription_max'] = $sortie->getNbInscriptionsMax();
            $info_sortie['infos_sortie'] = $sortie->getInfosSortie();
            $info_sortie['etat_sortie'] = $sortie->getEtatSortir();
            $info_sortie['url_photo'] = $sortie->getUrlPhoto();


            $tab_sorties[] = $info_sortie;
        }

        $json["sortie"] = $tab_sorties;
        //-----------------------------------------------------------
        //---------------------API LIEUX----------------------------
        $lieux = $lieuxRepo->findAll();
        $tab_lieux = [];
        foreach ($lieux as $lieu) {
            $info_lieu['id'] = $lieu->getId();
            $info_lieu['ville_id'] = $lieu->getVille()->getId();
            $info_lieu['nom_lieu'] = $lieu->getNomLieu();
            $tab_lieu['rue'] = $lieu->getRue();
            $tab_lieu['latitude'] = $lieu->getLatitude();
            $tab_lieu['longtitude'] = $lieu->getLongitude();
        }

        $json["lieu"] = $tab_lieux;
        //-----------------------------------------------------------
        //---------------------API VILLE----------------------------
        $villes = $villeRepo->findAll();
        $tab_villes = [];
        foreach ($villes as $ville) {
            $info_ville['id'] = $ville->getId();
            $info_ville['nom_ville'] = $ville->getNomVille();
            $info_ville['code_postal'] = $ville->getCodePostal();
            $tab_villes[] = $info_ville;
        }

        $json["ville"] = $tab_villes;
        return $this->json($json);
        //-----------------------------------------------------------

    }
}
