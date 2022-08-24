<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Form\CreerSortieType;
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

//CREATION D'UNE SORTIE : fonction creation et publication

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
    /*/**
     * @Route("/sortie/creation", name="app_sortie_publish")
     *
    public function sortiePublish(ManagerRegistry $doctrine,$id = -1, Request $request): Response
    {

        $sortie = new Sortie();

        if ($id > 0 ){
            $repoSortie = $doctrine->getRepository(Sortie::class);

            $sortie = $repoSortie->find($id);
        }

        $createForm = $this->createForm(CreerSortieType::class, $sortie);

        $createForm->handleRequest($request);

        if ($createForm->isSubmitted() && $createForm->isValid()){
            if ($request->get('save')->isClicked){
                $sortie->setEtat('Ouvert');
            }
            $sortieToSave = $createForm->getData();

            $sortieToSave->setDateHeureDebut(new \Datetime());
            $em = $doctrine->getManager();
            $em->persist($sortieToSave);
            $em->flush();

            return $this->redirectToRoute("app_home", [
                "id" => $sortieToSave->getId()
            ]);
        }

        return $this->render('sortie/index.html.twig', [
            "createForm" => $createForm->createView()
        ]);
    }*/

//MODIFICATION D'UNE SORTIE : fonction update, publication, supprimer

    /**
     * @Route("/sortie/modifier/{id}", name="app_sortie_modification")
     */
    public function sortieModifier(EntityManagerInterface $entityManager,$id, Request $request): Response
    {

        $repoSortie = $entityManager->getRepository(Sortie::class);
        $sortie = $repoSortie->find($id);


        $updateForm = $this->createForm(CreerSortieType::class, $sortie);

        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()){
            if ($request->get('save')->isClicked){
                $sortie->setEtat('En création');
            }
            $sortieToSave = $updateForm->getData();

            $sortieToSave->setDateHeureDebut(new \Datetime());
            $entityManager->persist($sortieToSave);
            $entityManager->flush();

            return $this->redirectToRoute("app_home", [
                "id" => $sortieToSave->getId()
            ]);
        }

        return $this->render('sortie/modifierSortie.html.twig', [
            "updateForm" => $updateForm->createView()
        ]);
    }

    /**
     * @Route("/sortie/modifier", name="app_sortie_supprimer")
     */

    public function deleteSortie(ManagerRegistry $doctrine, $id, Request $request){

        $em = $doctrine->getEntityManager();
        $sortie = $em->getRepository()->find($id);
        if ($request->get('delete')->isClicked){
        $em->remove($sortie);
        $em->flush();
        }
        return $this->redirectToRoute('app_home');
    }

    private function updateForm(string $class, $sortie)
    {
    }

}
