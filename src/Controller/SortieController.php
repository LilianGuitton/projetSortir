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
     * @Route("/sortie/creation", name="app_sortie_creation")
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
     * @Route("/sortie/creation", name="app_sortie_creation")
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
}
