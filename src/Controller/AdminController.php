<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RechercheType;
use App\Repository\VilleRepository;
use App\Repository\CampusRepository;
use App\Entity\Ville;
use App\Controller\VilleController;
use App\Form\VilleType;


class AdminController extends AbstractController
{


    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/admin/ville", name="app_ville")
     */
    public function ville(Request $request, VilleRepository $villeRepository): Response
    {
        $recherche = $request->get('recherche');
        $listeVille = $villeRepository->findAll();
        if ($recherche != null){
            $listeVille = $villeRepository->rechercheVille($recherche['recherche']);
        }

        $rechercheForm = $this->createForm(RechercheType::class, $recherche);


        return $this->render('admin/ville.html.twig', [
            'rechercheForm' => $rechercheForm->createView(),
            'controller_name' => 'AdminController',
            'villes' => $listeVille
        ]);
    }


    /**
     * @Route("/admin/campus", name="app_campus")
     */
    public function campus(Request $request, CampusRepository $CampusRepository): Response
    {
        $recherche = $request->get('recherche');
        $listeCampus = [];
        if ($recherche != null){
            $listeCampus = $CampusRepository->rechercheCampus($recherche['recherche']);
        }


        $rechercheForm = $this->createForm(RechercheType::class, $recherche);

        return $this->render('admin/campus.html.twig', [
            'rechercheForm' => $rechercheForm->createView(),
            'controller_name' => 'AdminController',
            'campus' => $listeCampus
        ]);
    }


}
