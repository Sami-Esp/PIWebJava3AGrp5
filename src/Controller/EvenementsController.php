<?php

namespace App\Controller;

use App\Repository\EvenementsRepository;
use App\Entity\Evenements;
use App\Form\EvenementsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementsController extends AbstractController
{
    #[Route('/evenements', name: 'app_evenements')]
    public function index(): Response
    {
        return $this->render('Evenements/index.html.twig', [
            'controller_name' => 'EvenementsController',
        ]);
    }

    #[Route('/showDBEvenements', name: 'showDBEvenements')]
    public function showDBEvenements(EvenementsRepository $EvenementsRepo): Response
    {

        $x = $EvenementsRepo->findAll();
        return $this->render('Evenements/showDBEvenements.html.twig', [
            'Evenements' => $x
        ]);
    }
    #[Route('/showEvenements', name: 'showEvenements')]
    public function showEvenements(EvenementsRepository $EvenementsRepo): Response
    {

        $x = $EvenementsRepo->findAll();
        return $this->render('Evenements/showEvenements.html.twig', [
            'Evenements' => $x
        ]);
    }

    #[Route('/addEvenements', name: 'addEvenements')]
    public function addEvenements(ManagerRegistry $manager, Request $req): Response
    {
        $em = $manager->getManager();
        $Evenements = new Evenements();
        $form = $this->createForm(EvenementsType::class,   $Evenements);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($Evenements);
            $em->flush();

            return $this->redirectToRoute('showDBEvenements');
        }

        return $this->renderForm('Evenements/add.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/editEvenements/{id}', name: 'editEvenements')]
    public function editEvenements($id, ManagerRegistry $manager, EvenementsRepository $Evenementsrepo, Request $req): Response
    {
        // var_dump($id) . die();

        $em = $manager->getManager();
        $idData = $Evenementsrepo->find($id);
        // var_dump($idData) . die();
        $form = $this->createForm(EvenementsType::class, $idData);
        $form->handleRequest($req);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($idData);
            $em->flush();

            return $this->redirectToRoute('showDBEvenements');
        }

        return $this->renderForm('Evenements/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/deleteEvenements/{id}', name: 'deleteEvenements')]
    public function deleteEvenements($id, ManagerRegistry $manager, EvenementsRepository $repo): Response
    {
        $emm = $manager->getManager();
        $idremove = $repo->find($id);
        $emm->remove($idremove);
        $emm->flush();


        return $this->redirectToRoute('showDBEvenements');
    }


}


