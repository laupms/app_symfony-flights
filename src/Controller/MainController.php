<?php

namespace App\Controller;

use App\Repository\AirlineRepository;
use App\Repository\AirportRepository;
use App\Repository\FlightsRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class MainController extends AbstractController
{
    #[Route('/', name: 'home')]

    public function home(
        FlightsRepository $flightsRepository,
        AirportRepository $airportRepository,
        AirlineRepository $airlineRepository
    ): Response
    {
        $lastFlights = $flightsRepository->findLastFlights();
        $lastAirport = $airportRepository->findLastAirport();
        $lastAirline = $airlineRepository->findLastAirline();

        return $this->render('main/home.html.twig', [
            'lastFlights' => $lastFlights,
            'lastAirport' => $lastAirport,
            'lastAirline' => $lastAirline,
            'controller_name' => 'MainController',
        ]);
    }

}
