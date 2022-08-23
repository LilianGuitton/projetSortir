<?php

namespace App\Controller;

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
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        if (!$this->getUser()){
            throw new AccessDeniedException("Non connecté");
        }

        $test = "";

        if($request->isMethod("post")){
            $test = $request->request->get("test", "1");
        }

        $conn = $doctrine->getManager()->getConnection();

        $sql = "SELECT * FROM Sortie s";

        $stmt = $conn->query($sql);
        $sortieList = $stmt->fetchAllAssociative();

        return $this->render('home/index.html.twig', ["sortieList" => $sortieList, "test" => $test]);
    }
}
