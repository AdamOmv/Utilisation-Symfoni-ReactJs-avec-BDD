<?php

namespace App\Controller;

use App\Entity\Utilisateurs;
use App\Repository\UtilisateursRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(UtilisateursRepository $utilisateursRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'users' => $utilisateursRepository->findAll(),
        ]);
    }

    #[Route('/monApi/utilisateurs', name: 'get_all_utilisateurs', methods: ['GET'])]
    public function getAll(): Response
    {
        $utilisateurs = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->findAll();
        $data = [];

        foreach ($utilisateurs as $utilisateur) {
            $data[] = [
                'id' => $utilisateur->getId(),
                'nom' => $utilisateur->getNom(),
                'prenom' => $utilisateur->getPrenom(),
                'email' => $utilisateur->getEmail(),
                'adresse' => $utilisateur->getAdresse(),
                'tel' => $utilisateur->getTel(),
                'birthDate' => $utilisateur->getBirthDate()
            ];
        }

        return $this->json($data);
    }

    #[Route('/monApi/utilisateurs/{id}', name: 'get_all_utilisateur', methods: ['GET'])]
    public function getOne(int $id): Response
    {
        $utilisateur = $this->getDoctrine()
            ->getRepository(Utilisateurs::class)
            ->find($id);

        if (!$utilisateur) {

            return $this->json('No utilisateur found for id' . $id, 404);
        }

        $data =  [
            'id' => $utilisateur->getId(),
            'nom' => $utilisateur->getNom(),
            'prenom' => $utilisateur->getPrenom(),
            'email' => $utilisateur->getEmail(),
            'adresse' => $utilisateur->getAdresse(),
            'tel' => $utilisateur->getTel(),
            'birthDate' => $utilisateur->getBirthDate()
        ];

        return $this->json($data);
    }
}
