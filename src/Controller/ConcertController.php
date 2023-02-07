<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConcertController extends AbstractController
{
    #[Route('/concert', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('concert/index.html.twig', [
            'controller_name' => 'ConcertController',
        ]);
    }

    #[Route('/concert/{name}', name: 'list')]
    public function list(string $name): Response
    {
        return $this->render('concert/list.html.twig', [
            'name' => $name,
            'concerts' => ['Dionysos', 'Deftones']
        ]);
    }
}
