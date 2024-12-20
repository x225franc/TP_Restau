<?php

namespace App\Controller;

use App\Entity\RestaurantTable;
use App\Form\RestaurantTableType;
use App\Repository\RestaurantRepository;
use App\Repository\RestaurantTableRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/table')]
final class TableController extends AbstractController
{
    #[Route(name: 'table_index', methods: ['GET'])]
    public function index(RestaurantTableRepository $tableRepository): Response
    {
        if ($this->isGranted('ROLE_BANNED')) {
            return $this->redirectToRoute('banned');
        }

        return $this->render('table/index.html.twig', [
            'tables' => $tableRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'table_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, RestaurantRepository $restaurantRepository): Response
    {
        if ($this->isGranted('ROLE_BANNED')) {
            return $this->redirectToRoute('banned');
        }

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($restaurantRepository->count([]) === 0) {
            $this->addFlash('error', 'Vous devez créer un restaurant avant de créer une table.');
            return $this->redirectToRoute('table_index');
        }

        $table = new RestaurantTable();
        $form = $this->createForm(RestaurantTableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($table);
            $entityManager->flush();

            return $this->redirectToRoute('table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('table/new.html.twig', [
            'table' => $table,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'table_show', methods: ['GET'])]
    public function show(RestaurantTable $table): Response
    {
        if ($this->isGranted('ROLE_BANNED')) {
            return $this->redirectToRoute('banned');
        }

        return $this->render('table/show.html.twig', [
            'table' => $table,
        ]);
    }

    #[Route('/{id}/edit', name: 'table_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RestaurantTable $table, EntityManagerInterface $entityManager): Response
    {
        if ($this->isGranted('ROLE_BANNED')) {
            return $this->redirectToRoute('banned');
        }

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(RestaurantTableType::class, $table);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('table_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('table/edit.html.twig', [
            'table' => $table,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'table_delete', methods: ['POST'])]
    public function delete(Request $request, RestaurantTable $table, EntityManagerInterface $entityManager): Response
    {
        if ($this->isGranted('ROLE_BANNED')) {
            return $this->redirectToRoute('banned');
        }

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if ($this->isCsrfTokenValid('delete' . $table->getId(), $request->get('_token'))) {
            try {
                $entityManager->remove($table);
                $entityManager->flush();
            } catch (ForeignKeyConstraintViolationException $e) {
                $this->addFlash('error', 'Impossible de supprimer cette table car elle est liée à d\'autres éléments.');
                return $this->redirectToRoute('table_index');
            }
        }

        return $this->redirectToRoute('table_index', [], Response::HTTP_SEE_OTHER);
    }
}
