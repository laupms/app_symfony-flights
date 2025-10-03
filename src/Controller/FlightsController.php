<?php

namespace App\Controller;

use App\Entity\Flights;
use App\Form\FlightsType;
use App\Repository\FlightsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class FlightsController extends AbstractController
{
    // affichage de la page d'accueil avec la liste des vols sans pouvoir la modifier, pour un visiteur lambda
    #[Route('/', name: 'app_flights_index', methods: ['GET'])]
    public function index(FlightsRepository $flightsRepository): Response
    {
        return $this->renderForm('flights/index.html.twig', [
            'flights' => $flightsRepository->findAll(),
        ]);
    }
}