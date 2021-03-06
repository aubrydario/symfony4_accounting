<?php

namespace App\Controller;

use App\Entity\Bill;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DashboardController extends AbstractController
{
    /**
     * @Route("/api/users/{id}/billsAndAbos")
     */
    public function getAbos($id) {
        $bills = $this->getDoctrine()
            ->getRepository(Bill::class)
            ->findAllBillsAndAbosByUserIdGroupByAbo($id);

        return new JsonResponse($bills);
    }

    /**
     * @Route("/api/users/{id}/bills")
     */
    public function getBills($id) {
        $bills = $this->getDoctrine()
            ->getRepository(Bill::class)
            ->findAllBillsAndAbosByUserId($id);

        return new JsonResponse($bills);
    }

    /**
     * @Route("/", name="homepage")
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        return $this->render('default/dashboard.html.twig');
    }
}
