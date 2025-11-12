<?php

namespace App\Controller;

use App\Entity\Discount;
use App\Form\DiscountType;
use App\Repository\AirlineRepository;
use App\Repository\DiscountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('admin/discount', name: 'admin_')]
class DiscountController extends AbstractController
{
    #[Route('/', name: 'discount', methods: ['GET'])]
    public function index(DiscountRepository $discountRepository, AirlineRepository $airlineRepository): Response
    {
        $airline = $airlineRepository->findBy([], ['name' => 'ASC']);
        return $this->render('admin/discount/index.html.twig', [
            'discounts' => $discountRepository->findAll(),
            'airline' => $airline,
        ]);
    }

    #[Route('/new', name: 'discount_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, DiscountRepository $discountRepository): Response
    {
        $discount = new Discount();
        $form = $this->createForm(DiscountType::class, $discount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $airline = $discount->getAirline();
            $start = $discount->getDateStart();
            $end = $discount->getDateEnd();

            // Vérifie si une réduction existe déjà pour la même compagnie et des dates qui se chevauchent
            $existingDiscounts = $discountRepository->createQueryBuilder('d')
                ->where('d.airline = :airline')
                ->andWhere('(:start BETWEEN d.date_start AND d.date_end OR :end BETWEEN d.date_start AND d.date_end OR (d.date_start BETWEEN :start AND :end))')
                ->setParameter('airline', $airline)
                ->setParameter('start', $start)
                ->setParameter('end', $end)
                ->getQuery()
                ->getResult();

            if ($existingDiscounts) {
                $this->addFlash('error', '❗️ Une réduction existe déjà pour cette compagnie sur cette période.');
                return $this->renderForm('admin/discount/new.html.twig', [
                    'discount' => $discount,
                    'form' => $form,
                ]);
            }

            $entityManager->persist($discount);
            $entityManager->flush();

            return $this->redirectToRoute('admin_discount', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/discount/new.html.twig', [
            'discount' => $discount,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'discount_show', methods: ['GET'])]
    public function show(Discount $discount): Response
    {
        return $this->render('admin/discount/show.html.twig', [
            'discount' => $discount,
        ]);
    }

    #[Route('/{id}/edit', name: 'discount_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Discount $discount, EntityManagerInterface $entityManager, DiscountRepository $discountRepository): Response
    {
        $form = $this->createForm(DiscountType::class, $discount);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $airline = $discount->getAirline();
            $start = $discount->getDateStart();
            $end = $discount->getDateEnd();

            // Vérifie si une réduction existe déjà pour la même compagnie et des dates qui se chevauchent
            $existingDiscounts = $discountRepository->createQueryBuilder('d')
                ->where('d.airline = :airline')
                ->andWhere('d.id != :currentId')
                ->andWhere('(:start BETWEEN d.date_start AND d.date_end OR :end BETWEEN d.date_start AND d.date_end OR (d.date_start BETWEEN :start AND :end))')
                ->setParameter('airline', $airline)
                ->setParameter('start', $start)
                ->setParameter('end', $end)
                ->setParameter('currentId', $discount->getId())
                ->getQuery()
                ->getResult();

            if ($existingDiscounts) {
                $this->addFlash('error', '❗️ Une réduction existe déjà pour cette compagnie sur cette période.');
                return $this->renderForm('admin/discount/edit.html.twig', [
                'discount' => $discount,
                'form' => $form,
                ]);      
            }


            $entityManager->flush();

            return $this->redirectToRoute('admin_discount', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/discount/edit.html.twig', [
            'discount' => $discount,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'discount_delete', methods: ['POST'])]
    public function delete(Request $request, Discount $discount, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$discount->getId(), $request->request->get('_token'))) {
            $entityManager->remove($discount);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_discount', [], Response::HTTP_SEE_OTHER);
    }
}
