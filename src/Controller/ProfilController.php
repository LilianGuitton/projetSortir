<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\MonProfilType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class ProfilController extends AbstractController
{


    /**
     * @Route("/profil", name="app_profil")
     */
    public function index(EntityManagerInterface $entityManager, Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $monProfil = $this->getUser();

        $monProfilForm = $this->createForm(MonProfilType::class,$monProfil);

        $monProfilForm->handleRequest($request);

        if ($monProfilForm->isSubmitted() && $monProfilForm->isValid()){

            $monProfil->setPassword(
                $userPasswordHasher->hashPassword(
                    $monProfil,
                    $monProfilForm->get('password')->getData()
                )
            );

            $entityManager->persist($monProfil);
            $entityManager->flush();

            return $this->redirectToRoute("app_home");
        }

        return $this->render('profil/index.html.twig', [
            'MonProfilForm' => $monProfilForm->createView(),


        ]);
    }


}
