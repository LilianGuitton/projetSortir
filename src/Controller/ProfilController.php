<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\MonProfilType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class ProfilController extends AbstractController
{


    /**
     * @Route("/profil", name="app_profil")
     */
    public function index(): Response
    {

        $monProfil = $this->getUser();

        

        $monProfilForm = $this->createForm(MonProfilType::class, $monProfil);
        return $this->render('profil/index.html.twig', [
            'MonProfilForm' => $monProfilForm->createView(),
        ]);
    }
}
