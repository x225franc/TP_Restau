<?php

namespace App\Controller;

use App\Repository\MenuRepository;
use App\Repository\ReservationRepository;
use App\Repository\RestaurantRepository;
use App\Repository\RestaurantTableRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function dashboard(
        MenuRepository $menuRepository,
        ReservationRepository $reservationRepository,
        RestaurantRepository $restaurantRepository,
        RestaurantTableRepository $tableRepository
    ): Response {
        if ($this->isGranted('ROLE_BANNED')) {
            return $this->redirectToRoute('banned');
        }

        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/dashboard.html.twig', [
            'menus' => $menuRepository->findAll(),
            'reservations' => $reservationRepository->findAll(),
            'restaurants' => $restaurantRepository->findAll(),
            'tables' => $tableRepository->findAll(),
        ]);
    }
}
