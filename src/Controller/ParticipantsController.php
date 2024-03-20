<?php

namespace App\Controller;

use App\Repository\ParticipantsRepository;
use App\Entity\Participants;
use App\Form\ParticipantsType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticipantsController extends AbstractController
{
    #[Route('/Participants', name: 'app_Participants')]
    public function index(): Response
    {
        return $this->render('Participants/index.html.twig', [
            'controller_name' => 'ParticipantsController',
        ]);
    }

    #[Route('/showDBParticipants', name: 'showDBParticipants')]
    public function showDBParticipants(ParticipantsRepository $ParticipantsRepo): Response
    {

        $x = $ParticipantsRepo->findAll();
        return $this->render('Participants/showDBParticipants.html.twig', [
            'Participants' => $x
        ]);
    }
    #[Route('/showParticipants', name: 'showParticipants')]
    public function showParticipants(ParticipantsRepository $ParticipantsRepo): Response
    {

        $x = $ParticipantsRepo->findAll();
        return $this->render('Participants/showParticipants.html.twig', [
            'Participants' => $x
        ]);
    }

    #[Route('/addParticipants', name: 'addParticipants')]
    public function addParticipants(ManagerRegistry $manager, Request $req): Response
    {
        $em = $manager->getManager();
        $Participants = new Participants();
        $form = $this->createForm(ParticipantsType::class,   $Participants);
        $form->handleRequest($req);
        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($Participants);
            $em->flush();

            return $this->redirectToRoute('showParticipants');
        }

        return $this->renderForm('Participants/addorigin.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/editParticipants/{id}', name: 'editParticipants')]
    public function editParticipants($id, ManagerRegistry $manager, ParticipantsRepository $Participantsrepo, Request $req): Response
    {
        // var_dump($id) . die();

        $em = $manager->getManager();
        $idData = $Participantsrepo->find($id);
        // var_dump($idData) . die();
        $form = $this->createForm(ParticipantsType::class, $idData);
        $form->handleRequest($req);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($idData);
            $em->flush();

            return $this->redirectToRoute('showDBParticipants');
        }

        return $this->renderForm('Participants/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/deleteParticipants/{id}', name: 'deleteParticipants')]
    public function deleteParticipants($id, ManagerRegistry $manager, ParticipantsRepository $repo): Response
    {
        $emm = $manager->getManager();
        $idremove = $repo->find($id);
        $emm->remove($idremove);
        $emm->flush();


        return $this->redirectToRoute('showDBParticipants');
    }

    
}


