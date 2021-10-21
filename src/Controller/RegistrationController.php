<?php

namespace App\Controller;

use App\Entity\Particpant;
use App\Form\RegistrationFormType;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/admin/register", name="app_register")
     * @param SiteRepository $sr
     * @param Request $request
     * @param UserPasswordHasherInterface $userPasswordHasherInterface
     * @return Response
     */
    public function register(SiteRepository $sr, Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $site = $sr->find(1);
        $user = new Particpant();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $user->setAdministrateur(true)->setSite($site)->setActif(true);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $admin =$form->get('admin')->getData();

            if($admin){
            $user->setRoles(['ROLE_ADMIN']);
            }

            $user->setPassword(
                $userPasswordHasherInterface->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('main');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
