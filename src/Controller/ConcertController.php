<?php

namespace App\Controller;

use App\Entity\Concert;
use App\Form\ConcertType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ConcertController extends AbstractController
{
    /**
     * @return Response
     */
    #[Route('/concert', name: 'homepage')]
    public function index(): Response
    {
        return $this->render('concert/index.html.twig', [
            'controller_name' => 'ConcertController',
        ]);
    }

    /**
     * Test attribute on url
     *
     * @param string $name
     * @return Response
     */
    #[Route('/concert/test/{name}', name: 'concerts_test')]
    public function test(string $name): Response
    {
        return $this->render('concert/list.html.twig', [
            'name' => $name,
            'concerts' => ['Dionysos', 'Deftones']
        ]);
    }


    /**
     * @return Response
     */
    #[Route('/concert', name: 'concerts_list')]
    public function list(): Response
    {
        return $this->render('concert/list.html.twig', [
            'name' => 'Laure',
            'concerts' => ['Dionysos', 'Deftones']
        ]);
    }

    /**
     * Create new concert
     *
     * @param Request $request
     * @param EntityManager $entityManager
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[NoReturn] #[Route("/concert/create", name: "concert_create")]
    #[IsGranted('ROLE_ADMIN')]
    public function createConcert(Request $request, EntityManagerInterface $entityManager): Response
    {
        $concert = new Concert();

        $form = $this->createForm(ConcertType::class, $concert);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $concert = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager->persist($concert);
            $entityManager->flush();

            $this->addFlash('success', 'Concert crée! Music is power!');
            return $this->redirectToRoute('homepage');
        }

        return $this->render('concert/new.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * Update concert
     *
     * @param Request $request
     * @param Concert $concert
     * @param EntityManager $entityManager
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route("/concert/edit/{id}", name:"concert_edit")]
    public function editConcert(Request $request, Concert $concert, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ConcertType::class, $concert);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $show = $form->getData();

            $entityManager->persist($concert);
            $entityManager->flush();

            $this->addFlash('success', 'Concert update! Music is power!');
            return $this->redirectToRoute('concerts_list');
        }

        return $this->render('concert/new.html.twig', [
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @param Request $request
     * @param Concert $concert
     * @param EntityManager $entityManager
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    #[Route("/concert/delete/{id}", name:"concert_delete")]
    public function delete(Request $request, Concert $concert, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($concert);
        $entityManager->flush();

        return $this->redirectToRoute('concerts_list');
    }
}
