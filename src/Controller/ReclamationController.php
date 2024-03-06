<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Flex\Options;






use Knp\Snappy\Pdf;


#[Route('/reclamation')]
class ReclamationController extends AbstractController
{
    #[Route('/', name: 'app_reclamation_index', methods: ['GET'])]
    public function index(ReclamationRepository $reclamationRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1); // Get current page from query string (default 1)
        $totalReclamations = count($reclamationRepository->findAll()); // Get total number of reclamations
    
        $perPage = 5; // Set the number of elements per page
    
        $totalPages = ceil($totalReclamations / $perPage); // Calculate total pages
    
        $offset = ($page - 1) * $perPage; // Calculate offset for the current page
    
        $reclamations = $reclamationRepository->findBy([], [], $perPage, $offset); // Fetch reclamations with limit and offset
    
        return $this->render('reclamation/index.html.twig', [
            'reclamations' => $reclamations,
            'page' => $page,
            'total_pages' => $totalPages,
        ]);
        }

    #[Route('/indexfront', name: 'app_reclamation_indexfront', methods: ['GET'])]
    public function indexfront(ReclamationRepository $reclamationRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1); // Get current page from query string (default 1)
        $totalReclamations = count($reclamationRepository->findAll()); // Get total number of reclamations
    
        $perPage = 5; // Set the number of elements per page
    
        $totalPages = ceil($totalReclamations / $perPage); // Calculate total pages
    
        $offset = ($page - 1) * $perPage; // Calculate offset for the current page
    
        $reclamations = $reclamationRepository->findBy([], [], $perPage, $offset); // Fetch reclamations with limit and offset
    
        return $this->render('reclamation/indexfront.html.twig', [
            'reclamations' => $reclamations,
            'page' => $page,
            'total_pages' => $totalPages,
        ]);
    }
   /*
#[Route('/listpdf', name: 'app_reclamation_listpdf', methods: ['GET'])]
        public function index1(ReclamationRepository $reclamationRepository, Request $request): Response
        {
            
               return $this->render('reclamation/listpdf.html.twig', [
         'reclamations' => $reclamationRepository->findAll(),
     ]);
            }*/
           /* #[Route('/listpdf', name: 'app_reclamation_listpdf', methods: ['GET'])]
public function listPdf(ReclamationRepository $reclamationRepository, Pdf $pdf): Response
{
    $reclamations = $reclamationRepository->findAll();

    $html = $this->renderView('reclamation/listpdf.html.twig', [
        'reclamations' => $reclamations,
    ]);

    $filename = 'reclamations.pdf';

    // Générer le PDF
    $pdf->generateFromHtml($html, $filename);

    // Renvoyer la réponse
    return new Response(
        $pdf->output(),
        200,
        [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => sprintf('attachment; filename="%s"', $filename),
        ]
    );
}*/
#[Route('/listpdf', name: 'app_reclamation_listpdf', methods: ['GET'])]
public function downloadcertif(ReclamationRepository $reclamationRepository)
{
    // Récupérer toutes les réclamations
    $reclamations = $reclamationRepository->findAll();

    // Configuration de Dompdf
    $pdfOptions = new Options();
    // $pdfOptions->set('defaultFont', 'poppins');
    // $pdfOptions->setIsRemoteEnabled(true);

    // Initialisation de Dompdf
    $dompdf = new Dompdf($pdfOptions);

    // Générer le HTML à partir du template Twig
    $html = $this->renderView('reclamation/listpdf.html.twig', [
        'reclamations' => $reclamations,
    ]);

    // Charger le HTML dans Dompdf
    $dompdf->loadHtml($html);

    // Définir le format de papier et l'orientation
    $dompdf->setPaper('A4', 'portrait');

    // Rendu du PDF
    $dompdf->render();

    // Nom du fichier PDF de sortie
    $fichier = 'user-data-' . '.pdf';

    // Envoyer le PDF en tant que réponse
    return new Response($dompdf->output(), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="' . $fichier . '"'
    ]);
}

    #[Route('/new', name: 'app_reclamation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }
    #[Route('/newfront', name: 'app_reclamation_newfront', methods: ['GET', 'POST'])]
    public function newf(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/newfront.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_show', methods: ['GET'])]
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }
  
    #[Route('/{id}/edit', name: 'app_reclamation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reclamation_delete', methods: ['POST'])]
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }



}
