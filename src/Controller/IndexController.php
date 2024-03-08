<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;



class IndexController extends AbstractController
{
    


 #[Route('/index', name: 'app_index', methods: ['GET'])]
 public function index(ServiceRepository $serviceRepository,Request $request): Response
 {
    $nomSearch = $request->query->get('nomSearch');
       
    $dureeServiceSearch = $request->query->get('dureeServiceSearch');
    $nomSearch = $nomSearch ?? '';
$dureeServiceSearch = $dureeServiceSearch ?? '';
    // Utilisation de la méthode findByCombinedSearch pour effectuer la recherche
    $services = $serviceRepository->findByCombinedSearch($nomSearch, $dureeServiceSearch);


 

    return $this->render('/basebase.html.twig', [
        'service' =>  $services
       
    ]);

 }

}  
    
 

 