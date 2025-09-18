<?php

namespace App\Controller;

use App\Entity\Cities;
use App\Form\CitiesType;
use App\Repository\CitiesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/cities')]
class CitiesController extends AbstractController
{
    //liste des villes
    #[Route('/', name: 'cities_index', methods: ['GET'])]
    public function index(CitiesRepository $citiesRepository): Response
    {
        return $this->render('cities/index.html.twig', [
            'cities' => $citiesRepository->findAll(),
        ]);
    }

    //créer une nouvelle ville
    #[Route('/new', name: 'cities_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $city = new Cities();
        $form = $this->createForm(CitiesType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($city);
            $entityManager->flush();

            return $this->redirectToRoute('cities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/cities/new.html.twig', [
            'city' => $city,
            'form' => $form,
        ]);
    }

    //modifier une ville existante
    #[Route('/{id}/edit', name: 'cities_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cities $city, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CitiesType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('cities_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/cities/edit.html.twig', [
            'city' => $city,
            'form' => $form,
        ]);
    }

    //supprimer une ville existante
    #[Route('/{id}', name: 'cities_delete', methods: ['POST'])]
    public function delete(Request $request, Cities $city, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$city->getId(), $request->request->get('_token'))) {
            $entityManager->remove($city);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cities_index', [], Response::HTTP_SEE_OTHER);
    }
}
