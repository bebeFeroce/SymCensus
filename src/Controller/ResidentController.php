<?php

namespace App\Controller;

use App\Repository\ResidentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResidentController extends AbstractController
{
    #[Route('/habitant', 'resident.index', methods: ['GET'])]
    public function index(
        ResidentRepository $repository
    ): Response
    {
        $residents = $repository->findAll();
        return $this->render('pages/resident/index.html.twig', [
            'residents' => $residents,
        ]);
    }
}
