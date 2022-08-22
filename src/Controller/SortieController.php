<?php

namespace App\Controller;

use App\Form\CreerSortieType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

//    /**
//     * @Route("/sortie/create/{id}", name="app_sortie_create")
//     */
//    public function sortieCreate($id = -1, Request $request): Response
//    {
//
//        $sortie = new Sortie();
//
//        if ($id > 0 ){
//            $repoSortie = $this->getDoctrine()->getRepository(Sortie::class);
//
//            $sortie = $repoSortie->find($id);
//        }
//
//
//        $createForm = $this->createForm(CreerSortieType::class, $sortie);
//
//        createForm->handleRequest($request);
//
//        if (createForm->isSubmitted() && $createForm->isValid()){
//
//            $sortieToSave = $createForm->getData();
//
//
//            // c'est ici quon génére un slug en théorie quand necessaire
//
//            // -- partie base de données
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($sortieToSave);
//            $em->flush();
//
//            // Message temporaire
//            $this->addFlash("message_success", "Idea successfully added!");
//
//
//            return $this->redirectToRoute("app_wish_show", [
//                "id" => $sortieToSave->getId()
//            ]);
//        }
//
//        // -- Sinon juste afficherr le formualaire vide par défaut (premiere fois)
//        // Retourner le rendu
//        return $this->render('wish/wish-form.html.twig', [
//            "wishForm" => $createForm->createView()
//        ]);
//    }
}
