<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Form\RechercheType;
use App\Repository\CampusRepository;
use App\Services\Slugify;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/campus")
 */
class CampusController extends AbstractController
{
    /**
     * @Route("/new", name="app_campus_new", methods={"GET", "POST"})
     */
    public function new(Request $request, CampusRepository $campusRepository): Response
    {
        $campus = new Campus();
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $slugify = new Slugify();
            $campus->setSlug($slugify->slugify($campus->getNom()));
            $campusRepository->add($campus, true);

            return $this->redirectToRoute('app_campus', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('campus/new.html.twig', [
            'campus' => $campus,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/edit/{slug}", name="app_campus_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, $slug, CampusRepository $campusRepository): Response
    {
        $campus = $campusRepository->findOneBy(array("slug"=>$slug));
        $form = $this->createForm(CampusType::class, $campus);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $campusRepository->add($campus, true);

            return $this->redirectToRoute('app_campus', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('campus/edit.html.twig', [
            'campus' => $campus,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{slug}", name="app_campus_delete", methods={"POST"})
     */
    #IsGranted["ROLE_ADMIN"]
    public function delete(Request $request, $slug, CampusRepository $campusRepository): Response
    {
        $campus = $campusRepository->findOneBy(array("slug"=>$slug));
        if ($this->isCsrfTokenValid('delete'.$campus->getId(), $request->request->get('_token'))) {
            $campusRepository->remove($campus, true);
        }

        return $this->redirectToRoute('app_campus', [], Response::HTTP_SEE_OTHER);
    }
}
