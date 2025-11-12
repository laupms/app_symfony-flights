<?php

namespace App\Controller;

use App\Entity\Airline;
use App\Form\AirlineType;
use App\Repository\AirlineRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('admin/airline', name: 'admin_')]
class AirlineController extends AbstractController
{
    //liste des compagnies
    #[Route('/', name: 'airline', methods: ['GET'])]
    public function index(AirlineRepository $airlineRepository): Response
    {
        return $this->render('admin/airline/index.html.twig', [
            'airlines' => $airlineRepository->findAll(),
        ]);
    }

    //créer une nouvelle compagnie
    #[Route('/new', name: 'airline_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $airline = new Airline();
        $form = $this->createForm(AirlineType::class, $airline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $logoFile = $form->get('logo')->getData();
            if($logoFile){
                $newLogoname = uniqid() . '.' . $logoFile->guessExtension();
                try{
                    $logoFile->move(
                        $this->getParameter('images_directory'),
                        $newLogoname
                    );
                } catch (FileException $e) {
                    //gérer erreur d'upload
                }

                $airline->setLogo($newLogoname);
            }


            $entityManager->persist($airline);
            $entityManager->flush();

            return $this->redirectToRoute('admin_airline', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/airline/new.html.twig', [
            'airline' => $airline,
            'form' => $form,
        ]);
    }

    //voir détail d'une compagnie
    #[Route('/{id}', name: 'airline_show', methods: ['GET'])]
    public function show(Airline $airline): Response
    {
        return $this->render('admin/airline/show.html.twig', [
            'airline' => $airline,
        ]);
    }

    //modifier une compagnie
    #[Route('/{id}/edit', name: 'airline_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Airline $airline, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AirlineType::class, $airline);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $logoFile = $form->get('logo')->getData();
            if($logoFile){
                // Supprime l'ancien logo s'il existe
                if($airline->getLogo()){
                    $oldPath = $this->getParameter('images_directory') . '/' . $airline->getLogo();
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
                // Nouveau nom unique
                $newFilename = uniqid().'.'.$logoFile->guessExtension();

                // Déplace le logo dans le fichier logo-airlines
                $logoFile->move(
                $this->getParameter('images_directory'),
                $newFilename);

                $airline->setLogo($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('admin_airline', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/airline/edit.html.twig', [
            'airline' => $airline,
            'form' => $form,
        ]);
    }

    //supprimer une compagnie
    #[Route('/{id}', name: 'airline_delete', methods: ['POST'])]
    public function delete(Request $request, Airline $airline, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$airline->getId(), $request->request->get('_token'))) {
            $entityManager->remove($airline);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_airline', [], Response::HTTP_SEE_OTHER);
    }
}
