<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReservationRepository;
use App\Entity\Reservation;

class MesReservationsController extends AbstractController
{
    /**
     * @Route("/mes/reservations", name="mes_reservations")
     */
    public function index(ReservationRepository $reservationRepository): Response
    {

        return $this->render('mes_reservations/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }
}
