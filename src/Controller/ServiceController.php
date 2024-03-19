<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/service')]
class ServiceController extends AbstractController

{
    
    #[Route('/', name: 'app_service_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $perPage = 3;
    
        // Récupérer le terme de recherche depuis la requête
        $searchTerm = $request->query->get('search', '');
    
        // Si un terme de recherche est fourni, utilisez-le dans la requête
        if ($searchTerm) {
            $criteria = ['service' => $searchTerm]; // Remplacez 'service' par le champ que vous souhaitez rechercher
        } else {
            $criteria = [];
        }
    
        $totalService = count($serviceRepository->findBy($criteria));
        $totalPages = ceil($totalService / $perPage);
        $offset = ($page - 1) * $perPage;
    
        $service = $serviceRepository->findBy($criteria, [], $perPage, $offset);
    
        return $this->render('service/index.html.twig', [
            'service' => $service,
            'page' => $page,
            'total_pages' => $totalPages,
            'search_term' => $searchTerm,
        ]);
    }
    

    #[Route('/new', name: 'app_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($service);
            $entityManager->flush();
            $brochureFile = $form->get('photo')->getData();

// this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($brochureFile) {
                $originalFilename = pathinfo($brochureFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$brochureFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $brochureFile->move(
                        $this->getParameter('brochures_directory'),
                        $newFilename
                    );
                } catch (FileException $e)
                 {
                    // ... handle exception if something happens during file upload
                }
                $service->setPhoto($newFilename);
                $entityManager->persist($service);
                $entityManager->flush();


            }


            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }



    
    #[Route('/Front/{id}', name: 'app_service_front', methods: ['GET'])]
    public function showfront(Service $service): Response
    {
      
        return $this->render('service/servicefront.html.twig', [
            'service' => $service,
        ]);
    }


    #[Route('/{id}', name: 'app_service_show', methods: ['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }




    




    #[Route('/{id}/edit', name: 'app_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
    }
}
