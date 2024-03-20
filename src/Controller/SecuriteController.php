<?php

namespace App\Controller;

use App\Entity\Role;
use App\Entity\Utilisateur;
use App\Form\RegistrationType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
#use Symfony\Component\DependencyInjection\ContainerInterface;
#use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecuriteController extends AbstractController
{
    #[Route('/securite', name: 'app_securite')]
    public function index(): Response
    {
        return $this->render('securite/index.html.twig', [
            'controller_name' => 'SecuriteController',
        ]);
    }

    #[Route('/pages-register.html', name: 'app_securite_registration')]
    public function registration(Request $request, ObjectManager $manager, UserPasswordHasherInterface $passwordHasher/*, ContainerInterface $container*/): Response {
        $utilisateur = new Utilisateur();

        $form = $this->createForm(RegistrationType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $passwordHasher->hashPassword($utilisateur, $utilisateur->getMdp());
            $utilisateur->setMdp($hash);

            $roleClient = $manager->getRepository(Role::class)->findOneBy(['nom' => 'CLIENT']);
            if ($roleClient) {
                $utilisateur->setRole($roleClient);
            } else {
                $roleClient = new Role();
                $roleClient->setNom('CLIENT');
                $manager->persist($roleClient);
                $manager->flush();
                $utilisateur->setRole($roleClient);
            }

            $manager->persist($utilisateur);
            $manager->flush();
            
            return $this->redirectToRoute('app_securite_login');
        }

        return $this->render('securite/registration.html.twig',[
            'form' => $form->createView()
        ]);
    }
    
    #[Route('/pages-login.html', name: 'app_securite_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response {
       // get the login error if there is one
       $error = $authenticationUtils->getLastAuthenticationError();
       // last username entered by the user
       $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('securite/login.html.twig', [
            #'controller_name' => 'LoginController',
             'last_username' => $lastUsername,
             'error'         => $error,
        ]);
    }
    #[Route('/deconnexion', name: 'app_securite_logout')]
    public function logout() {}
    #[Route('/', name: 'app_home')]
    public function home() {
        return $this->render('baseuer/index.html.twig');
    }
    
}
