<?php

namespace App\Controller;

use App\Repository\BandRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BandController extends AbstractController
{

    /**
     * Render a group list
     *
     * @param BandRepository $bandRepository
     * @return Response
     */
    #[Route('/bands', name: 'band_list')]
    public function bandsAll(BandRepository $bandRepository): Response
    {
        $bands = $bandRepository->findAll();

        return $this->render('band/list.html.twig', [
            'bands' => $bands
        ]);
    }

    /**
     * Render a group
     *
     * @param int $id
     * @param BandRepository $bandRepository
     * @return Response
     */

    #[Route('/bands/{id}', name: 'band_show')]
    public function list(int $id, BandRepository $bandRepository): Response
    {
        return $this->render('band/band.html.twig', [
                'band' => $bandRepository->find($id)
            ]
        );
    }


}
