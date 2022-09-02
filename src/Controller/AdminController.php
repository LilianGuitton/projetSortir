<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Participant;
use App\Form\AnnulerSortieType;
use App\Form\UploadCSVType;
use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SortieRepository;
use App\Services\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\RechercheType;
use App\Repository\VilleRepository;
use App\Repository\CampusRepository;
use App\Entity\Ville;
use App\Controller\VilleController;
use App\Form\VilleType;
use League\Csv\Reader;

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
    public function ville(Request $request, VilleRepository $villeRepository): Response
    {
        $recherche = $request->get('recherche');

        if ($recherche != null){
            $listeVille = $villeRepository->rechercheVille($recherche['recherche']);
        } else {
            $listeVille = $villeRepository->findAll();
        }

        $rechercheForm = $this->createForm(RechercheType::class, $recherche);

        return $this->render('admin/ville.html.twig', [
            'rechercheForm' => $rechercheForm->createView(),
            'controller_name' => 'AdminController',
            'villes' => $listeVille
        ]);
    }


    /**
     * @Route("/admin/campus", name="app_campus")
     */
    public function campus(Request $request, CampusRepository $CampusRepository): Response
    {
        $recherche = $request->get('recherche');
        if ($recherche != null){
            $listeCampus = $CampusRepository->rechercheCampus($recherche['recherche']);
        } else {
            $listeCampus = $CampusRepository->findAll();
        }

        $rechercheForm = $this->createForm(RechercheType::class, $recherche);

        return $this->render('admin/campus.html.twig', [
            'rechercheForm' => $rechercheForm->createView(),
            'controller_name' => 'AdminController',
            'campus' => $listeCampus
        ]);
    }

    /**
     * @Route("/admin/participants", name="app_participants_admin")
     */
    public function participants(ParticipantRepository $repoParticipant): Response
    {
        $participants = $repoParticipant->findAll();

        return $this->render('admin/participants.html.twig', [
            "participants" => $participants
        ]);
    }

    /**
     * @Route("/admin/participants/add", name="app_register_multiple")
     */
    public function registerParticipants(ParticipantRepository $repoParticipant, Request $request, UserPasswordHasherInterface $userPasswordHasher, Slugify $slugify, CampusRepository $repoCampus): Response
    {
        $uploadForm = $this->createForm(UploadCSVType::class);
        $uploadForm->handleRequest($request);

        if ($uploadForm->isSubmitted() && $uploadForm->isValid()){
            ini_set('max_execution_time', 0);
            $file = $uploadForm->get('file')->getData();
            $csv = Reader::createFromPath($file->getPathname(), 'r');
            $csv->setHeaderOffset(0);
            $defaultHeader = ["pseudo", "prenom", "nom", "telephone", "email", "campus"];
            $header = $csv->getHeader();
            $records = $csv->getRecords();
            if ($header != $defaultHeader){
                return $this->redirectToRoute("app_register_multiple");
            }
            foreach ($records as $record){
                $participant = $repoParticipant->findOneBy(array("pseudo"=>$record["pseudo"]));

                if ($participant==null) {
                    $participant = new Participant();
                    $participant->setPassword($userPasswordHasher->hashPassword($participant, 'Pa$$w0rd'));
                    $participant->setPseudo($record["pseudo"]);
                    $participant->setPrenom($record["prenom"]);
                    $participant->setNom($record["nom"]);
                    $participant->setTelephone($record["telephone"]);
                    $participant->setEmail($record["email"]);
                    $participant->setSlug($slugify->slugify($record["pseudo"]));
                    $participant->setActif(true);

                    $campus = $repoCampus->findOneBy(array("nom" => $record["campus"]));

                    if ($campus == null) {
                        $campus = new Campus();
                        $campus->setNom($record["campus"]);
                        $campus->setSlug($slugify->slugify($record["campus"]));
                        $repoCampus->add($campus, true);
                    }

                    $participant->setEstRattacherA($campus);

                    $repoParticipant->add($participant, true);
                }
            }
            return $this->redirectToRoute("app_participants_admin");
        }

        return $this->render('admin/ajoutParticipants.html.twig', [
            "uploadForm" => $uploadForm->createView()
        ]);
    }

    /**
     * @Route("/admin/participant/disable/{slug}", name="app_participant_disable")
     */
    public function disableParticipants(ParticipantRepository $repoParticipant, $slug): Response
    {
        $participant = $repoParticipant->findOneBy(array("slug"=>$slug));
        $participant->setActif(false);
        $repoParticipant->add($participant, true);

        return $this->redirectToRoute("app_participants_admin");
    }

    /**
     * @Route("/admin/participant/enable/{slug}", name="app_participant_enable")
     */
    public function enableParticipants(ParticipantRepository $repoParticipant, $slug): Response
    {
        $participant = $repoParticipant->findOneBy(array("slug"=>$slug));
        $participant->setActif(true);
        $repoParticipant->add($participant, true);

        return $this->redirectToRoute("app_participants_admin");
    }

    /**
     * @Route("/admin/participant/delete/{slug}", name="app_participant_delete")
     */
    public function deleteParticipants(ParticipantRepository $repoParticipant, $slug): Response
    {
        $participant = $repoParticipant->findOneBy(array("slug"=>$slug));
        $repoParticipant->remove($participant, true);

        return $this->redirectToRoute("app_participants_admin");
    }

    /**
     * @Route("/admin/sorties", name="app_sorties_admin")
     */
    public function sorties(SortieRepository $repoSortie): Response
    {
        $sorties = $repoSortie->findAll();

        return $this->render('admin/sorties.html.twig', [
            "sorties" => $sorties
        ]);
    }

    /**
     * @Route("/admin/sortie/annuler/{slug}", name="app_annuler_sortie_admin")
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

            return $this->redirectToRoute("app_sorties_admin");
        }

        return $this->render('/admin/annulerSortie.html.twig', [
            'cancelForm' => $cancelForm->createView(),
            'sortie' => $sortie
        ]);
    }
}
