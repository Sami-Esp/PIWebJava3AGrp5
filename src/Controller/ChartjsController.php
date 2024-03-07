<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Association;
use App\Repository\DonRepository;


class ChartjsController extends AbstractController
{
    #[Route('/chartjs', name: 'app_chartjs')]
    public function chart(DonRepository $donRepository): Response
{
    // Récupérer toutes les associations
    $associations = $this->getDoctrine()->getRepository(Association::class)->findAll();

    // Initialiser un tableau pour stocker les données des dons par association
    $data = [];

    // Pour chaque association, compter le nombre de dons et stocker dans le tableau $data
    foreach ($associations as $association) {
        $donCount = $donRepository->count(['association' => $association->getId()]);
        $data[$association->getNom()] = $donCount;
    }

    return $this->render('chartjs/index.html.twig', [
        'data' => json_encode($data), // Convertir les données en format JSON pour utiliser avec Chart.js
    ]);
}
    
}



