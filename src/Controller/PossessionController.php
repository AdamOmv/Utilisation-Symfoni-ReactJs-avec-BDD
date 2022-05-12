<?php

namespace App\Controller;

use App\Entity\Possessions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;

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
    public function getAll(ManagerRegistry $doctrine, SerializerInterface $serializer): Response
    {
        $possessions = $doctrine->getRepository(Possessions::class)->findAll();

        $json = $serializer->serialize($possessions, 'json');

        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    #[Route('/monApi/possessions/{id}', name: 'get_one_possession', methods: ['GET'])]
    public function getOne(int $id, ManagerRegistry $doctrine, SerializerInterface $serializer): Response
    {
        $possession = $doctrine->getRepository(Possessions::class)->find($id);

        if (!$possession) {
            return $this->json('No possession found for id' . $id, 404);
        }

        $json = $serializer->serialize($possession, 'json');

        $response = new Response($json);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
