<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\AssociationRepository;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends AbstractController
{
   

    #[Route('/base', name: 'app_base', methods: ['GET'])]
    public function index(AssociationRepository $associationRepository, Request $request): Response
    { 
        $nomSearch = $request->query->get('nomSearch');
       
        $lieuSearch = $request->query->get('lieuSearch');
        $nomSearch = $nomSearch ?? '';
    $lieuSearch = $lieuSearch ?? '';
        // Utilisation de la méthode findByCombinedSearch pour effectuer la recherche
        $associations = $associationRepository->findByCombinedSearch($nomSearch, $lieuSearch);
    

     

        return $this->render('association/basebase.html.twig', [
            'associations' =>  $associations
           
        ]);
    }

   
       
    }


 
   