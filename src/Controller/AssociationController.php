<?php

namespace App\Controller;

use App\Entity\Association;
use App\Form\AssociationType;
use App\Repository\AssociationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use VictorPrad\RecaptchaBundle\Validator\Constraints as Recaptcha;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/association')]
class AssociationController extends AbstractController
{
    #[Route('/', name: 'app_association_index', methods: ['GET'])]
    public function index(AssociationRepository $associationRepository, PaginatorInterface $paginator,Request $request): Response
    {

        $allassociation =$associationRepository ->findAll();

        $associations = $paginator->paginate(
            $allassociation, 
            $request->query->getInt('page', 1), 
            2//
        );
        return $this->render('association/index.html.twig', [
            'associations' =>  $associations ,
           
        ]);
    }

    #[Route('/associations', name: 'app_association_front', methods: ['GET'])]
    public function indexfront(AssociationRepository $associationRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $nomSearch = $request->query->get('nomSearch');
       
        $lieuSearch = $request->query->get('lieuSearch');
        $nomSearch = $nomSearch ?? '';
    $lieuSearch = $lieuSearch ?? '';
        // Utilisation de la méthode findByCombinedSearch pour effectuer la recherche
        $associations = $associationRepository->findByCombinedSearch($nomSearch, $lieuSearch);
      
        $associations = $paginator->paginate(
            $associations, // Utilisez les résultats filtrés par la recherche
            $request->query->getInt('page', 1), 
            6
        );
        return $this->render('association.html.twig', [
            'associations' =>  $associations
        ]);
    }





    #[Route('/pdf/{id}', name: 'app_pdf_generator')]
    public function generatePdf(Association $association): Response
    {
        if (!$association) {
            throw $this->createNotFoundException('Association not found');
        }

        $data = [
            'association' => $association,
        ];

        $html = $this->renderView('association/pdfAssociation.html.twig', $data);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        // Generate the PDF
        $dompdf = new Dompdf();
        $dompdf->setOptions($options);
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response(
            $dompdf->stream('association/associationFront.html.twig', ["Attachment" => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }



        
    #[Route('/new', name: 'app_association_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $a = new Association();
        $form = $this->createForm(AssociationType::class, $a);
        $form->handleRequest($request);

        


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($a);
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
                $a->setPhoto($newFilename);
                $entityManager->persist($a);
                $entityManager->flush();


            }
            return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
        }



        return $this->renderForm('association/new.html.twig', [
            'association' => $a,
            'form' => $form,
        ]);
    }


    #[Route('/newf', name: 'app_association_newf', methods: ['GET', 'POST'])]
    public function newf(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $a = new Association();
        $form = $this->createForm(AssociationType::class, $a);
        $form->handleRequest($request);

        


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($a);
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
                $a->setPhoto($newFilename);
                $entityManager->persist($a);
                $entityManager->flush();


            }
            return $this->redirectToRoute('app_base', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('association/newf.html.twig', [
            'association' => $a,
            'form' => $form,
        ]);
    }




    #[Route('/{id}', name: 'app_association_show', methods: ['GET'])]
    public function show(Association $association): Response
    {
      
        return $this->render('association/show.html.twig', [
            'association' => $association,
        ]);
    }

    #[Route('/Front/{id}', name: 'association_Front', methods: ['GET'])]
    public function showFront(Association $association): Response
    {
      
        return $this->render('association/associationFront.html.twig', [
            'association' => $association,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_association_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Association $association, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AssociationType::class, $association);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($association);
            $entityManager->flush();
            
            return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('association/edit.html.twig', [
            'association' => $association,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_association_delete', methods: ['POST'])]
    public function delete(Request $request, Association $association, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$association->getId(), $request->request->get('_token'))) {
            $entityManager->remove($association);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_association_index', [], Response::HTTP_SEE_OTHER);
    }
}




