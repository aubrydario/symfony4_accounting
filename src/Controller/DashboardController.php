<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Entity\Payment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {
        return $this->render('default/dashboard.html.twig');
    }

    /**
     * @Route("/api/bills")
     * @Method("GET")
     */
    public function getBillsAction()
    {
        $bills = $this->getDoctrine()
            ->getRepository(Bill::class)
            ->findAllBills();
        return new JsonResponse($bills);
    }

    /**
     * @Route("/api/payments")
     * @Method("GET")
     */
    public function getPaymentsAction()
    {
        $payments = $this->getDoctrine()
            ->getRepository(Payment::class)
            ->findAllPayments();

        return new JsonResponse($payments);
    }
}
