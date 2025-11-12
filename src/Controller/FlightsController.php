<?php

namespace App\Controller;

use App\Entity\Flights;
use App\Form\FlightsType;
use App\Repository\FlightsRepository;
use App\Repository\AirlineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/flights')]
class FlightsController extends AbstractController
{
    // affichage de la page d'accueil avec la liste des vols sans pouvoir la modifier, pour un visiteur lambda
    #[Route('/', name: 'app_flights_index', methods: ['GET'])]
    public function index(FlightsRepository $flightsRepository, AirlineRepository $airlineRepository): Response
    {
        $airline = $airlineRepository->findBy([], ['name' => 'ASC']);
        return $this->renderForm('flights/index.html.twig', [
            'flights' => $flightsRepository->findAll(),
            'airline' => $airline,
        ]);
    }

     //voir les détails d'un vol dans la liste
    #[Route('/{id}', name: 'app_flights_show', methods: ['GET']), IsGranted('ROLE_USER')]
    public function show(Flights $flight): Response
    {
        return $this->render('flights/show.html.twig', [
            'flight' => $flight,
        ]);
    }
}