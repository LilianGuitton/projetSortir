<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Form\AnnulerSortieType;
use App\Form\CreerSortieType;
use App\Repository\EtatRepository;
use App\Repository\SortieRepository;
use App\Services\Slugify;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use http\Client\Curl\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Sortie;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\String\ByteString;


class SortieController extends AbstractController
{
    /**
     * @Route("/sortie/afficher/{slug}", name="app_afficher_sortie")
     */
    public function afficherSortie($slug, SortieRepository $repoSortie): Response
    {
        $sortie = $repoSortie->findOneBy(array("slug" => $slug));

        if ($sortie==null){
            return $this->redirectToRoute("app_home");
        }

        return $this->render('sortie/afficherSortie.html.twig', [
            'sortie'=>$sortie
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

            $slugify = new Slugify();

            if ("save" === $request->get('save')){
                $sortie->setEtat($entityManager->getRepository(Etat::class)->find(1));
            } elseif ("publish" === $request->get('publish')){
                $sortie->addParticipant($this->getUser());
                $sortie->setEtat($entityManager->getRepository(Etat::class)->find(2));
            }

            $sortie->setCampus($this->getUser()->getEstRattacherA());
            $sortie->setOrganisateur($this->getUser());
            $random = ByteString::fromRandom(4)->toString();
            $sortie->setSlug($slugify->slugify($sortie->getNom() . " " .$random));

            $entityManager->persist($sortie);
            $entityManager->flush();



            return $this->redirectToRoute("app_home");
        }

        return $this->render('sortie/index.html.twig', [
            "createForm" => $createForm->createView()
        ]);
    }

//MODIFICATION D'UNE SORTIE : fonction update, supprimer

    /**
     * @Route("/sortie/modifier/{slug}", name="app_sortie_modification")
     */
    public function sortieModifier(
        EntityManagerInterface $entityManager,
        $slug,
        Request $request,
        SortieRepository $repoSortie
    ): Response
    {
        $sortie = $repoSortie->findOneBy(array("slug" => $slug));

        if ($sortie->getEtat()->getLibelle()!="En création"){
            return $this->redirectToRoute("app_home");
        }

        if ($sortie==null){
            return $this->redirectToRoute("app_home");
        }

        $updateForm = $this->createForm(CreerSortieType::class, $sortie);
        $updateForm->handleRequest($request);

        if ($updateForm->isSubmitted() && $updateForm->isValid()){

            if ("save" === $request->get('save')){
                $sortie->setEtat($entityManager->getRepository(Etat::class)->find(1));
            } elseif ("publish" === $request->get('publish')){
                $sortie->addParticipant($this->getUser());
                $sortie->setEtat($entityManager->getRepository(Etat::class)->find(2));
            }

            $sortie->setCampus($this->getUser()->getEstRattacherA());
            $sortie->setOrganisateur($this->getUser());


            $entityManager->persist($sortie);
            $entityManager->flush();

            return $this->redirectToRoute("app_home");
        }

        return $this->render('sortie/modifierSortie.html.twig', [
            "updateForm" => $updateForm->createView(),
            "sortie"=> $sortie
        ]);
    }

    /**
     * @Route("/sortie/supprimer/{slug}", name="app_sortie_supprimer")
     */
    public function deleteSortie(EntityManagerInterface $entityManager,$slug, SortieRepository $repoSortie){

        $sortie = $repoSortie->findOneBy(array("slug" => $slug));

        if ($sortie==null){
            return $this->redirectToRoute("app_home");
        }

        $entityManager->remove($sortie);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }


//INSCRIPTION DANS UNE SORTIE : fonction inscrit/désinscrit
    /**
     * @Route ("/sortie/inscrit/{slug}", name="app_sortie_inscrit")
     */
    public function inscritSortie($slug, EntityManagerInterface $entityManager, SortieRepository $repoSortie){

        $sortie = $repoSortie->findOneBy(array("slug" => $slug));

        if ($sortie==null){
            return $this->redirectToRoute("app_home");
        }

        $sortie->addParticipant($this->getUser());

        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute("app_home");
    }

    /**
     * @Route ("/sortie/desinscrit/{slug}", name="app_sortie_desinscrit")
     */
    public function desinscritSortie(EntityManagerInterface $entityManager, SortieRepository $repoSortie, $slug){
        $sortie = $repoSortie->findOneBy(array("slug" => $slug));

        if ($sortie==null){
            return $this->redirectToRoute("app_home");
        }

        $sortie->removeParticipant($this->getUser());

        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute("app_home");
    }

    /**
     * @Route ("/sortie/publier/{slug}", name="app_sortie_publier")
     */
    public function publierSortie($slug, EntityManagerInterface $entityManager, EtatRepository $repoEtat, SortieRepository $repoSortie){
        $sortie = $repoSortie->findOneBy(array("slug" => $slug));

        if ($sortie==null){
            return $this->redirectToRoute("app_home");
        }

        $sortie->setEtat($repoEtat->find('2'));
        $sortie->addParticipant($this->getUser());

        $entityManager->persist($sortie);
        $entityManager->flush();

        return $this->redirectToRoute("app_home");
    }

//AFFICHAGE D'UNE SORTIE SUR LA TWIG ANNULER

    /**
     * @Route("/sortie/annuler/{slug}", name="app_annuler_sortie")
     */
    public function annulerSortie($slug, SortieRepository $repoSortie, Request $request, EtatRepository $repoEtat): Response
    {
        $sortie = $repoSortie->findOneBy(array("slug" => $slug));

        if ($sortie==null){
            return $this->redirectToRoute("app_home");
        }

        $cancelForm = $this->createForm(AnnulerSortieType::class, $sortie);
        $cancelForm->handleRequest($request);

        if ($cancelForm->isSubmitted() && $cancelForm->isValid()){
            $sortie->setEtat($repoEtat->find(7));

            $repoSortie->add($sortie, true);

            return $this->redirectToRoute("app_home");
        }

        return $this->render('sortie/annulerSortie.html.twig', [
            'cancelForm' => $cancelForm->createView(),
            'sortie' => $sortie
        ]);
    }
}
