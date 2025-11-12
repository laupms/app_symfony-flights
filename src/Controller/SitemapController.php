<?php

namespace App\Controller;

use App\Repository\FlightsRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class SitemapController extends AbstractController
{

    #[Route('/sitemap.xml', name: 'sitemap', defaults: ['_format' => 'xml'])]
    public function index(
        FlightsRepository $flightsRepository,
    ): Response {
        // Liste des pages statiques (accueil, mentions légales, etc.)
        $urls = [
            ['loc' => $this->generateUrl('home', [], 0)],
            ['loc' => $this->generateUrl('mentions-legales', [], 0)],
            ['loc' => $this->generateUrl('politique-confidentialite', [], 0)],
            ['loc' => $this->generateUrl('cgu', [], 0)],

        ];

        // Liste des vols
        $urls[] = [
            'loc' => $this->generateUrl('app_flights_index', [], UrlGeneratorInterface::ABSOLUTE_URL),
        ];

        // Chaque vol
        foreach ($flightsRepository->findAll() as $flight) {
            $urls[] = [
                'loc' => $this->generateUrl('app_flights_show', ['id' => $flight->getId()], 0),
                'lastmod' => $flight->getDeparture()?->format('Y-m-d'),
            ];
        }

        return $this->render('sitemap/index.xml.twig', [
            'urls' => $urls,
        ]);

    }
}
