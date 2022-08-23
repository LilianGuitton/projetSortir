<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Sortie;
use App\Form\FiltreType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_home")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->getUser()){
            throw new AccessDeniedException("Non connecté");
        }

        $filtre = $request->get("filtre");

        $nom = $filtre["nom"];
        $campus = $filtre["campus"];
        $debut = $filtre["debut"];
        $fin = $filtre["fin"];
        //$monOrga = $filtre["monOrga"];
        $inscrit = $filtre["inscrit"];
        //$nonInscrit = $filtre["nonInscrit"];
        $passee = $filtre["passee"];

        $repoSortie = $entityManager->getRepository(Sortie::class);

        $sortieList = $repoSortie->findAll();

        return $this->render('home/index.html.twig', ["sortieList" => $sortieList, "filtre"=>$filtre,
            "filterForm" => $this->createForm(FiltreType::class)->createView()
        ]);
    }
}
