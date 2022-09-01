<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Etat;
use App\Entity\Sortie;
use App\Form\FiltreType;
use App\Services\Slugify;
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

        $repoSortie = $entityManager->getRepository(Sortie::class);

        if ($filtre!=null){
            if ($filtre["debut"]==""){
                $filtre["début"]="1971-01-01";
            }
            if ($filtre["fin"]==""){
                $filtre["fin"]="2037-12-12";
            }
            $sortieList = $repoSortie->findByFilter($filtre["campus"], $filtre["nom"], $filtre["debut"], $filtre["fin"], isset($filtre["monOrga"]) ? $this->getUser()->getId() : 0, isset($filtre["passee"]) ? 5 : 0, isset($filtre["inscrit"]) ? $this->getUser()->getEstInscrit() : null, isset($filtre["nonInscrit"]) ? $this->getUser()->getEstInscrit() : null);
        } else {
            $sortieList = $repoSortie->findAllSortie();
        }

        return $this->render('home/index.html.twig', ["sortieList" => $sortieList, "filtre"=>$filtre,
            "filterForm" => $this->createForm(FiltreType::class)->createView()
        ]);
    }
}
