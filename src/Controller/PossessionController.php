<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PossessionController extends AbstractController
{
    #[Route('/possession', name: 'app_possession')]
    public function index(): Response
    {
        return $this->render('possession/index.html.twig', [
            'controller_name' => 'PossessionController',
        ]);
    }

    #[Route('/monApi/possessions', name: 'get_all_possessions', methods: ['GET'])]
    public function getAll(): Response
    {
        $possessions = $this->getDoctrine()
            ->getRepository(Possessions::class)
            ->findAll();
        $data = [];

        foreach ($possessions as $possession) {
            $data[] = [
                'id' => $possession->getId(),
                'nom' => $possession->getNom(),
                'valeur' => $possession->getValeur(),
                'type' => $possession->getType(),
            ];
        }

        return $this->json($data);
    }

    #[Route('/monApi/possessions/{id}', name: 'get_one_possession', methods: ['GET'])]
    public function getOne(int $id): Response
    {
        $possession = $this->getDoctrine()
            ->getRepository(Possessions::class)
            ->find($id);

        if (!$possession) {

            return $this->json('No possession found for id' . $id, 404);
        }

        $data =  [
            'id' => $possession->getId(),
            'nom' => $possession->getNom(),
            'valeur' => $possession->getValeur(),
            'type' => $possession->getType(),
        ];

        return $this->json($data);
    }
}
