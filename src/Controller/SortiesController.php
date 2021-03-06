<?php

namespace App\Controller;

use App\Entity\Inscriptions;
use App\Entity\Sorties;
use App\Form\AnnulerSortieType;
use App\Form\SortirType;
use App\Repository\EtatsRepository;
use App\Repository\InscriptionsRepository;
use App\Repository\LieuxRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/sorties", name="sorties_")
 */

class SortiesController extends AbstractController
{
    /**
     * @Route("/voir/{id}", name="voir")
     * @param int $id
     * @param SortiesRepository $sortiesRepository
     * @param InscriptionsRepository $inscriptionsRepository
     * @return Response
     */
    public function listSortie(int $id, SortiesRepository $sortiesRepository, InscriptionsRepository $inscriptionsRepository): Response
    {
        $participants = $inscriptionsRepository->findAllParticipantswithSortie($id);
        $sorties = $sortiesRepository->findOneById($id);
        // dd($participants);
        if (!$sorties) {
            throw $this->createNotFoundException("Oops la sortie n'existes pas");
        }

        return $this->render('sorties/liste.html.twig', [
            "sorties" => $sorties,
            "participants" => $participants
        ]);
    }


    /**
     * @Route("/create", name="create")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createSortie(EntityManagerInterface $entityManager, Request $request, LieuxRepository $lr, EtatsRepository $er): Response
    {
        $lieux = $lr->findAllWithVilles();
        $cree = $er->find(1);
        $ouverte = $er->find(2);
        $inscription = new Inscriptions;
        $sortie = new Sorties();
        $sortieForm = $this->createForm(SortirType::class, $sortie);
        $sortieForm->handleRequest($request);

        if ($sortieForm->isSubmitted() && $sortieForm->isValid()) {
            //geData() permet de recuprer les donner recu par  notre formulaire
            $sortie = $sortieForm->getData();
            $datedebut = new \DateTime($request->request->get('dateHeureDebut'));
            $sortie->setDateHeureDebut($datedebut);

            $datefin = new \DateTime($request->request->get('dateLimiteInscription'));
            $sortie->setDateLimiteInscription($datefin);


            // $datedebut = $sortieForm['dateHeureDebut']->getData();
            // $sortie->setDateHeureDebut(\DateTime::createFromFormat('Y/m/d H:i',$datedebut));

            //            $datefin = $sortieForm['dateLimiteInscription']->getData();
            //            $sortie->setDateLimiteInscription(\DateTime::createFromFormat('Y/m/d', $datefin));

            //si le boutton enregistrer est creer la sortie prend comme etat En creation
            //sinon si publier , etat_sortie est ouvert
            //sinon on revient a la page dacceuil
            if ($sortieForm->get('save')->isClicked()) {
                $sortie->setEtatSortir("En cr??ation");
                $sortie->setEtat($cree);
                
            } elseif ($sortieForm->get('publish')->isClicked()) {
                $sortie->setEtatSortir("Ouvert");
                $sortie->setEtat($ouverte);
            } else {
                return $this->redirectToRoute('sorties_create');
            }
            $inscription->setParticipants($this->getUser());
            $inscription->setSortie($sortie);
            
            $sortie->setOrganisateur($this->getUser());

            $entityManager->persist($inscription);
            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('success', 'Sortie Cr????e !');
            return $this->redirectToRoute('main');
        }


        return $this->render('sorties/sortie.html.twig', [
            "sortieForm" => $sortieForm->createView(),
            "lieux" => $lieux,
        ]);
    }

    /**
     * @Route("/modifier/{id}", name="modifier")
     * @param Sorties $sortie
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function modifier(SortiesRepository $sr, Request $request, EntityManagerInterface $entityManager, EtatsRepository $er, $id)
    {
        $sortie = $sr->findOneById($id);
        //dd($sortie);
        $sortieForm = $this->createForm(SortirType::class, $sortie);
        $sortieForm->handleRequest($request);
        //dd($sortieForm);
        $etat = $er->findAll();
        

        if ($sortieForm->isSubmitted()) {
            $sortie = $sortieForm->getData();

            if ($sortieForm->get('save')->isClicked()) {
                $sortie->setEtatSortir("En cr??ation");
                $sortie->setEtat($etat[0]);
            } elseif ($sortieForm->get('publish')->isClicked()) {
                $sortie->setEtatSortir("Ouvert");
                $sortie->setEtat($etat[1]);
            } else {
                $sortie->setEtatSortir("Annul??e");
                $sortie->setEtat($etat[5]);
                $sortie->setDescription("Sortie annul??e, contactez le SAV pour plus d'information !");
            }

            $entityManager->flush();
            $this->addFlash('success', 'La sortie a ??t?? modifi??e !');
            return $this->redirectToRoute('main');
        }

        return $this->render('sorties/modifier.html.twig', [
            //'page_name' => 'Sortie Edit',
            'sortie' => $sortie,
            'form' => $sortieForm->createView()
        ]);
    }

    /**
     * @Route("/annuler/{id}", name="annuler")
     * @param Sorties $sorties
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function annuler(Sorties $sorties, Request $request, EntityManagerInterface $entityManager): Response
    {

        $participant = $this->getUser();
        //  $sortie = new Sorties();
        $formAnnuller = $this->createForm(AnnulerSortieType::class, $sorties);
        $formAnnuller->handleRequest($request);

        if ($formAnnuller->isSubmitted() && $formAnnuller->isValid()) {

            //  $sorties->setInfosSortie($formAnnuller['infosSortie']->getData());
            $sorties->setEtatSortir("Annul??e");

            $entityManager->flush();
            $this->addFlash('success', 'La sortie a ??t?? annul??e !');
            return $this->redirectToRoute('main');
        }
        return $this->render('sorties/annuler.html.twig', [
            'sorties' => $sorties,
            'participants' => $participant,
            "formAnnuller" => $formAnnuller->createView()
        ]);
    }
}

