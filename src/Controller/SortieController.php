<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Form\CreerSortieType;
use App\Repository\EtatRepository;
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

            dump($request->get('save'));

            if ("save" === $request->get('save')){
                $sortie->setEtat($entityManager->getRepository(Etat::class)->find(1));
            } elseif ("publish" === $request->get('publish')){
                $sortie->setEtat($entityManager->getRepository(Etat::class)->find(2));
            }


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

    /**
     * @Route ("/sortie/publier/{sortie}", name="app_sortie_publier")
     */
    public function publierSortie(Sortie $sortie, EntityManagerInterface $entityManager, EtatRepository $repoEtat){
        $sortie->setEtat($repoEtat->find('2'));

        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute("app_home");
    }
}
