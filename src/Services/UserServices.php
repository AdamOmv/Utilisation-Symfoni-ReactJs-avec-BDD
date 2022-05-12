<?php

namespace App\Services;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserServices extends AbstractController
{
    #[Route('/UserServices/calculAge/{dateN}', name: 'calcul_age', methods: ['GET'])]
    public function calculAge(\DateTime $dateN): Response
    {
        $dateAjd = new \DateTime();
        $age = date_diff($dateN, $dateAjd);
        return $this->json($age->format('%y'));
    }
}
