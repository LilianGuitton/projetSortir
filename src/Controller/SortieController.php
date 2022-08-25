<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Form\CreerSortieType;
use App\Repository\SortieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Sortie;


class SortieController extends AbstractController
{
    /**
     * @Route("/sortie", name="app_sortie")
     */
    public function index(): Response
    {
        return $this->render('sortie/index.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

    /**
     * @Route("/sortie/afficher", name="app_afficher_sortie")
     */
    public function afficherSortie(): Response
    {
        return $this->render('sortie/afficherSortie.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }


   /**
     * @Route("/sortie/annuler", name="app_annuler_sortie")
     */
    public function annulerSortie(): Response
    {
        return $this->render('sortie/annulerSortie.html.twig', [
            'controller_name' => 'SortieController',
        ]);
    }

//CREATION D'UNE SORTIE : fonction creation

    /**
     * @Route("/sortie/creation", name="app_sortie_creation")
     */
    public function sortieCreate(EntityManagerInterface $entityManager, Request $request): Response
    {

        $sortie = new Sortie();

        $createForm = $this->createForm(CreerSortieType::class, $sortie);

        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()){

            $sortie->setEtat($entityManager->getRepository(Etat::class)->find(1));

            $sortie->setCampus($this->getUser()->getEstRattacherA());
            $sortie->setOrganisateur($this->getUser());

            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute("app_home", [
                "id" => $sortie->getId()
            ]);
        }

        return $this->render('sortie/index.html.twig', [
            "createForm" => $createForm->createView()
        ]);
    }

//MODIFICATION D'UNE SORTIE : fonction update, supprimer

    /**
     * @Route("/sortie/modifier/{sortie}", name="app_sortie_modification")
     */
    public function sortieModifier(
        EntityManagerInterface $entityManager,
        Sortie $sortie,
        Request $request,
        SortieRepository $repoSortie
    ): Response
    {

        //$repoSortie = $entityManager->getRepository(Sortie::class);
//        $sortie = $repoSortie->find($id);
       dump($sortie);
        $updateForm = $this->createForm(CreerSortieType::class, $sortie);

        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()){

            $sortie->setEtat($entityManager->getRepository(Etat::class)->find(1));

            $sortie->setCampus($this->getUser()->getEstRattacherA());
            $sortie->setOrganisateur($this->getUser());


            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute("app_home", [
                "id" => $sortie->getId()
            ]);
        }

        return $this->render('sortie/modifierSortie.html.twig', [
            "updateForm" => $updateForm->createView(),
            "sortie"=> $sortie
        ]);
    }

    /**
     * @Route("/sortie/supprimer/{id}", name="app_sortie_supprimer")
     */
    public function deleteSortie(EntityManagerInterface $entityManager,Sortie $sortie ){

        $entityManager->remove($sortie);
        $entityManager->flush();

        return $this->redirectToRoute('app_home', [
        "sortie" => $sortie->getId()
            ]);
    }


//INSCRIPTION DANS UNE SORTIE : fonction inscrit/désinscrit
    /**
     * @Route ("/sortie/inscrit/{sortie}", name="app_sortie_inscrit")
     */
    public function inscritSortie(Sortie $sortie, EntityManagerInterface $entityManager){
        $sortie->addParticipant($this->getUser());

        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute("app_home");
    }

    /**
     * @Route ("/sortie/desinscrit/{sortie}", name="app_sortie_desinscrit")
     */
    public function desinscritSortie(Sortie $sortie, EntityManagerInterface $entityManager){
        $sortie->removeParticipant($this->getUser());

        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute("app_home");
    }

//AFFICHAGE D'UNE SORTIE SUR LA TWIG ANNULER

   /**
     * @Route ("/sortie/annuler/{sortie}", name="app_annuler_sortie")







    public function wishList(): Response
    {
        // Repo Wish
        $repoWish = $this->getDoctrine()->getRepository(Wish::class); // Récuperer l'entity manager doctrine

        // la liste de tout les voeux
        //  $wishList = $repoWish->findAll();
        $wishList = $repoWish->findBy(array(), null, 20, null);

        return $this->render('wish/index.html.twig', [
            "wishList" => $wishList
        ]);
    } */




}
