<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalController extends AbstractController
{
    #[Route('/mentions-legales', name: 'mentions-legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('legal/mentions_legales.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }

    #[Route('/politique-confidentialite', name: 'politique-confidentialite')]
    public function politiqueConfidentialite(): Response
    {
        return $this->render('legal/politique_confidentialite.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }

    #[Route('/cgu', name: 'cgu')]
    public function conditionsUtilisation(): Response
    {
        return $this->render('legal/cgu.html.twig', [
            'controller_name' => 'LegalController',
        ]);
    }

}
