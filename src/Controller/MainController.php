<?php

namespace App\Controller;

use App\Entity\Lieux;
use App\Entity\Site;
use App\Repository\InscriptionsRepository;
use App\Repository\ParticpantRepository;
use App\Repository\SiteRepository;
use App\Repository\SortiesRepository;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use PHPUnit\Util\Json;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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
        $form = $this->createFormBuilder()
            ->add('site', EntityType::class, [
                'class' => Site::class,
                "label" => "Site organisateur : ",
                'attr' => [
                    'class' => 'form-control'
                ],
                'choice_label' => function ($site) {
                    return $site->getNomSite();
                }
            ])
            ->add('nomSortie', TextType::class, [
                "label" => "Le nom de la sortie contient : ",
                "attr"  => [
                    "class"       => "form-control",
                    "placeholder" => "ex. sortie en plein air !",
                ],
                'required' => false
            ])
            ->add('dateDebut', DateType::class, [
                'label'    => 'Entre ',
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle' => 'datetimepicker',
                    'data-target' => '#sortie_dateHeureDebut'
                ],
                'mapped' => false,
                'required' => false
            ])
            ->add('dateFin', DateType::class, [
                "label" => " et ",
                'html5' => true,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control datetimepicker-input',
                    'data-toggle' => 'datetimepicker',
                    'data-target' => '#sortie_dateLimiteInscription'
                ],
                'mapped' => false,
                'required' => false
            ])
            ->add('sortie_check', ChoiceType::class, array(
                'choices' => array(
                    'Sorties dont je suis organisateur/trice' => 'sortie_orga',
                    'Sorties auxquelles je suis inscrit/e' => 'sortie_inscrit',
                    'Sorties auxquelles je ne suis pas inscrit/e' => 'sortie_non_inscrit',
                    'Sorties passées' => 'sortie_passee',
                ),
                'label' => ' ',
                'expanded' => true,
                'multiple' => true,
                'required' => false
            ))
            // ->add('submit', SubmitType::class, [
            //     'label' => 'Rechercher'
            // ])
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $test =$form->getData();
            //dd($test); 
            $idSite = $test['site']->getId();
            dd($idSite);
            
            // $requete ="";
            // if ($nomSortie){
            //     $requete += "nomSortie IS LIKE '".$nomSortie."';";
            // }
            // if ($dateDebut){
            //     $requete += "dateHeureDebut > ".$dateDebut."';";
            // }
            // if ($dateFin){
            //     $requete += "dateHeureDebut > ".$dateFin."';";
            // }
            // if ($sortie_orga){
            //     $requete += " organisateurId =".$this->getUser()->getmyuid;
            // }
            
        }
        $formView = $form->createView();
        $tab = compact('inscriptions', 'sites', 'participants', 'formView');
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
