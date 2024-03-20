<?php

namespace App\Controller;

use App\Entity\DemandeService;
use App\Entity\Service;
use App\Form\DemandeServiceType;
use App\Repository\DemandeServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
#[Route('/demande/service')]
class DemandeServiceController extends AbstractController
{
    #[Route('/', name: 'app_demande_service_index', methods: ['GET'])]
    public function index(DemandeServiceRepository $demandeServiceRepository): Response
    {
        return $this->render('demande_service/index.html.twig', [
            'demande_services' => $demandeServiceRepository->findAll(),
        ]);
    }


    #[Route('/pdf/{id}', name: 'app_pdf_generator')]
    public function generatePdf(DemandeService $demandeservice): Response
    {
        if (!$demandeservice) {
            throw $this->createNotFoundException('demandeservice not found');
        }

        $data = [
            'demandeservice' => $demandeservice,
        ];

        $html = $this->renderView('demande_service/pdfdemandeservice.html.twig', $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Generate the PDF
        $dompdf = new Dompdf();
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response(
            $dompdf->stream('demande_service/index.html.twig', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }


    #[Route('/addservice/{id}', name: 'app_service_add', methods: ['GET', 'POST'])]
    public function addservice(Request $request, EntityManagerInterface $entityManager ,int $id): Response
    {
        $demandeService = new DemandeService();
        $form = $this->createForm(DemandeServiceType::class, $demandeService);
        $form->handleRequest($request);

        $service = $entityManager->getRepository(Service::class)->find($id);
        $demandeService->setService($service);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demandeService);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_index', ['id' => $id], Response::HTTP_SEE_OTHER);

        }

        return $this->renderForm('demande_service/addservice.html.twig', [
            'demande_service' => $demandeService,
            'form' => $form,
            'service' => $service,
        ]);
    }

    #[Route('/new/{id}', name: 'app_demande_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager ,int $id): Response
    {
        $demandeService = new DemandeService();
        $form = $this->createForm(DemandeServiceType::class, $demandeService);
        $form->handleRequest($request);

        $service = $entityManager->getRepository(Service::class)->find($id);
        $demandeService->setService($service);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($demandeService);
            $entityManager->flush();
            

            return $this->redirectToRoute('app_demande_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_service/new.html.twig', [
            'demande_service' => $demandeService,
            'form' => $form,
            'service' => $service,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_service_show', methods: ['GET'])]
    public function show(DemandeService $demandeService): Response
    {
        return $this->render('demande_service/show.html.twig', [
            'demande_service' => $demandeService,
        ]);
    }




    

    #[Route('/{id}/edit', name: 'app_demande_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DemandeService $demandeService, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DemandeServiceType::class, $demandeService);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_demande_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('demande_service/edit.html.twig', [
            'demande_service' => $demandeService,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_demande_service_delete', methods: ['POST'])]
    public function delete(Request $request, DemandeService $demandeService, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$demandeService->getId(), $request->request->get('_token'))) {
            $entityManager->remove($demandeService);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_demande_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
