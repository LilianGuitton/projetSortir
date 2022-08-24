<?php

namespace App\Controller;

use App\Entity\Lieu;
use App\Form\CreerSortieType;
use Doctrine\Persistence\ManagerRegistry;
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
     * @Route("/sortie/modifier", name="app_modifier_sortie")
     */
    public function modifierSortie(): Response
    {
        return $this->render('sortie/modifierSortie.html.twig', [
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
     * @Route("/sortie/creation/{id}", name="app_sortie_creation")
     */
    public function sortieCreate(ManagerRegistry $doctrine,$id = -1, Request $request): Response
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
                $sortie->setEtat('En création');
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
    }
    /**
     * @Route("/sortie/creation", name="app_sortie_publish")
     */
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
    }

//MODIFICATION D'UNE SORTIE : fonction update, publication, supprimer

    /**
     * @Route("/sortie/modifier/{id}", name="app_sortie_modification")
     */
    public function sortieModifier(ManagerRegistry $doctrine,$id = -1, Request $request): Response
    {

        $sortie = new Sortie();

        if ($id > 0 ){
            $repoSortie = $doctrine->getRepository(Sortie::class);

            $sortie = $repoSortie->find($id);
        }

        $updateForm = $this->createForm(CreerSortieType::class, $sortie);

        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()){
            if ($request->get('save')->isClicked){
                $sortie->setEtat('En création');
            }
            $sortieToSave = $updateForm->getData();

            $sortieToSave->setDateHeureDebut(new \Datetime());
            $em = $doctrine->getManager();
            $em->persist($sortieToSave);
            $em->flush();

            return $this->redirectToRoute("app_home", [
                "id" => $sortieToSave->getId()
            ]);
        }

        return $this->render('sortie/index.html.twig', [
            "updateForm" => $updateForm->createView()
        ]);
    }

    /**
     * @Route("/sortie/modifier", name="app_sortie_supprimer")
     */

    public function deleteSortie(ManagerRegistry $doctrine){

        $sortie = new Sortie();

        $em = $doctrine->getEntityManager();
        $em->remove($sortie);
        $em->flush();
    }

}
