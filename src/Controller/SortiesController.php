<?php

namespace App\Controller;

use App\Entity\Sorties;
use App\Form\SortirType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sorties", name="sorties_")
 */
class SortiesController extends AbstractController
{

    /**
     * @Route("/list", name="list")
     *
     */
    public function listSortie(): Response
    {
        return $this->render('sorties/liste.html.twig');

    }

    /**
     * @Route("/create", name="create")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     * @throws \Exception
     */
    public function createSortie(EntityManagerInterface $entityManager,Request $request): Response
    {
        $sortie = new Sorties();
        $sortieForm =$this->createForm(SortirType::class,$sortie);
        $sortieForm->handleRequest($request);
        if($sortieForm->isSubmitted() && $sortieForm->isValid()){
            //geData() peermet de recuprer les donner recu par  notre formulaire
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
            if( $sortieForm->get('save')->isClicked()) {
                $sortie->setEtatSortir("En création");
            }elseif( $sortieForm->get('publish')->isClicked()) {
                $sortie->setEtatSortir("Ouvert");
            }else{
               return $this->redirectToRoute('main');
                }

           // $sortie->setOrganisateur($this->getPseudo);

            $entityManager->persist($sortie);
            $entityManager->flush();
            $this->addFlash('success','Sortie Créer !' );
            return $this->redirectToRoute('sorties_create');
        }
        return $this->render('sorties/sortie.html.twig',[
            "sortieForm"=>$sortieForm->createView()
        ]);
    }
}

