<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\MonProfilType;
use App\Repository\ParticipantRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfilController extends AbstractController
{


    /**
     * @Route("/profil", name="app_profil")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();

        $monProfil = new Participant();
        $monProfil->setPseudo($user->getPseudo());
        $monProfil->setNom($user->getNom());

        $monProfilForm = $this->createForm(MonProfilType::class,$monProfil);

        dump($monProfil);
        dump($monProfilForm->isSubmitted());

        if ($monProfilForm->isSubmitted() && $monProfilForm->isValid()){

            $monProfil->setId($user->getId());

            $entityManager->persist($monProfil);
            $entityManager->flush();

            return $this->redirectToRoute("app_home");
        }

        return $this->render('profil/index.html.twig', [
            'MonProfilForm' => $monProfilForm->createView(),


        ]);
    }


}
