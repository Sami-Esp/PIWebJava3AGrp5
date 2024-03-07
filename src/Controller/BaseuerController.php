<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BaseuerController extends AbstractController
{
    #[Route('/baseuer', name: 'app_baseuer')]
    public function index(): Response
    {
        return $this->render('baseuer/index.html.twig', [
            'controller_name' => 'BaseuerController',
        ]);
    }
}
