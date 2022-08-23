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
    public function ville(Request $Request): Response
    {
        $recherche =$Request->get('recherche');


        $rechercheForm= $this->createForm(RechercheType::class,$recherche);


      //  foreach ($v in $ville[]){

   // }






        return $this->render('admin/ville.html.twig', [
            'rechercheForm' => $rechercheForm->createView(),
            'controller_name' => 'AdminController',

        ]);
    }



    /**
     * @Route("/admin/campus", name="app_campus")
     */
    public function campus(): Response
    {
        return $this->render('admin/campus.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }



}
