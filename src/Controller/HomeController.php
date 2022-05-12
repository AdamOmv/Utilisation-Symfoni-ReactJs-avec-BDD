<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Form\UtilisateurFormType;
use App\Repository\UtilisateursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

class HomeController extends AbstractController
{
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/home', name: 'home')]
    public function index(UtilisateursRepository $utilisateursRepository, Request $request): Response
    {
        $user = new Utilisateurs();
        $form = $this->createForm(UtilisateurFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($user);
            $this->em->flush();
        }

        return $this->render('home/index.html.twig', [
            'users' => $utilisateursRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    #[Route('/monApi/utilisateurs', name: 'get_all_utilisateurs', methods: ['GET'])]
    public function getAll(ManagerRegistry $doctrine, SerializerInterface $serializer): Response
    {
        $utilisateurs = $doctrine->getRepository(Utilisateurs::class)->findAll();
        $json = $serializer->serialize($utilisateurs, 'json');

        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route('/monApi/utilisateurs/{id}', name: 'get_all_utilisateur', methods: ['GET'])]
    public function getOne(int $id, ManagerRegistry $doctrine, SerializerInterface $serializer): Response
    {
        $utilisateur = $doctrine->getRepository(Utilisateurs::class)->find($id);

        if (!$utilisateur) {
            return $this->json('No utilisateur found for id' . $id, 404);
        }

        $json = $serializer->serialize($utilisateur, 'json');

        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;;
    }
}
