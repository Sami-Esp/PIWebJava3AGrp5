<?php

namespace App\Controller;

use App\Repository\SponsorsRepository;
use App\Entity\Sponsors;
use App\Form\SponsorsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SponsorsController extends AbstractController
{
    #[Route('/Sponsors', name: 'app_Sponsors')]
    public function index(): Response
    {
        return $this->render('Sponsors/index.html.twig', [
            'controller_name' => 'SponsorsController',
        ]);
    }

    #[Route('/showDBSponsors', name: 'showDBSponsors')]
    public function showDBSponsors(SponsorsRepository $SponsorsRepo): Response
    {

        $x = $SponsorsRepo->findAll();
        return $this->render('Sponsors/showDBSponsors.html.twig', [
            'Sponsors' => $x
        ]);
    }
    #[Route('/showSponsors', name: 'showSponsors')]
    public function showSponsors(SponsorsRepository $SponsorsRepo): Response
    {

        $x = $SponsorsRepo->findAll();
        return $this->render('Sponsors/showSponsors.html.twig', [
            'Sponsors' => $x
        ]);
    }

    #[Route('/addSponsors', name: 'addSponsors')]
    public function addSponsors(ManagerRegistry $manager, Request $req): Response
    {
        $em = $manager->getManager();
        $Sponsors = new Sponsors();
        $form = $this->createForm(SponsorsType::class,   $Sponsors);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($Sponsors);
            $em->flush();

            return $this->redirectToRoute('showSponsors');
        }

        return $this->renderForm('Sponsors/add.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/editSponsors/{id}', name: 'editSponsors')]
    public function editSponsors($id, ManagerRegistry $manager, SponsorsRepository $Sponsorsrepo, Request $req): Response
    {
        // var_dump($id) . die();

        $em = $manager->getManager();
        $idData = $Sponsorsrepo->find($id);
        // var_dump($idData) . die();
        $form = $this->createForm(SponsorsType::class, $idData);
        $form->handleRequest($req);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($idData);
            $em->flush();

            return $this->redirectToRoute('showDBSponsors');
        }

        return $this->renderForm('Sponsors/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/deleteSponsors/{id}', name: 'deleteSponsors')]
    public function deleteSponsors($id, ManagerRegistry $manager, SponsorsRepository $repo): Response
    {
        $emm = $manager->getManager();
        $idremove = $repo->find($id);
        $emm->remove($idremove);
        $emm->flush();


        return $this->redirectToRoute('showDBSponsors');
    }

}


