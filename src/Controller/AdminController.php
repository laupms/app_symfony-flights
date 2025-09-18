<?php

namespace App\Controller;

use App\Entity\Flights;
use App\Form\FlightsType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\ByteString;


use App\Repository\CitiesRepository;
use App\Repository\UserRepository;
use App\Repository\FlightsRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/admin', name: 'admin_'), isGranted('ROLE_ADMIN')]

class AdminController extends AbstractController
{
    //liste villes
    #[Route('/cities', name: 'cities_')]
    public function citiesList(CitiesRepository $cities){
        return $this->render("admin/cities/index.html.twig", [
            'cities' => $cities ->findAll()
        ]);
    }

    //liste utilisateurs
    #[Route('/user', name: 'user_')]
    public function userList(UserRepository $user){
        return $this->render("admin/user/index.html.twig", [
            'user' => $user ->findAll()
        ]);
    }

    //liste vols
    #[Route('/', name: 'index')]
    public function flightsList(FlightsRepository $flights){
        return $this->render("admin/flights/index.html.twig", [
            'flights' => $flights ->findAll()
        ]);
    }

    //créer nouveau vol
    #[Route('/flights/new', name: 'flights_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $flight = new Flights();

        //créer un numéro de vol aléatoire (juste pour l'ajout de nouveau vol)
        $flight->setNum(ByteString::fromRandom(2, 'ABCDEFGIJKLMNOPQRSTUVWXYZ') . ByteString::fromRandom(4, '0123456789'));

        $form = $this->createForm(FlightsType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($flight);
            $entityManager->flush();

            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/flights/new.html.twig', [
            'flight' => $flight,
            'form' => $form,
        ]);
    }

    //voir les détails d'un vol dans la liste
    #[Route('/flights/{id}', name: 'flights_show', methods: ['GET'])]
    public function show(Flights $flight): Response
    {
        return $this->render('admin/flights/show.html.twig', [
            'flight' => $flight,
        ]);
    }

    //modifier un vol dans la liste
    #[Route('/flights/{id}/edit', name: 'flights_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Flights $flight, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FlightsType::class, $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/flights/edit.html.twig', [
            'flight' => $flight,
            'form' => $form,
        ]);
    }

    //supprimer un vol dans la liste
    #[Route('/flights/{id}', name: 'flights_delete', methods: ['POST'])]
    public function delete(Request $request, Flights $flight, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flight->getId(), $request->request->get('_token'))) {
            $entityManager->remove($flight);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_index', [], Response::HTTP_SEE_OTHER);
    }

}
