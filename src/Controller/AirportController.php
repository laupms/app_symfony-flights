<?php

namespace App\Controller;

use App\Entity\Airport;
use App\Form\AirportType;
use App\Repository\AirportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/airport', name: 'admin_')]
class AirportController extends AbstractController
{
    #[Route('/', name: 'airport', methods: ['GET'])]
    public function index(AirportRepository $airportRepository): Response
    {
        return $this->render('admin/airport/index.html.twig', [
            'airports' => $airportRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'airport_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $airport = new Airport();
        $form = $this->createForm(AirportType::class, $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($airport);
            $entityManager->flush();

            return $this->redirectToRoute('admin_airport', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/airport/new.html.twig', [
            'airport' => $airport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'airport_show', methods: ['GET'])]
    public function show(Airport $airport): Response
    {
        return $this->render('admin/airport/show.html.twig', [
            'airport' => $airport,
        ]);
    }

    #[Route('/{id}/edit', name: 'airport_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Airport $airport, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AirportType::class, $airport);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_airport', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/airport/edit.html.twig', [
            'airport' => $airport,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'airport_delete', methods: ['POST'])]
    public function delete(Request $request, Airport $airport, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$airport->getId(), $request->request->get('_token'))) {
            $entityManager->remove($airport);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_airport', [], Response::HTTP_SEE_OTHER);
    }
}
