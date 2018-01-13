<?php

namespace App\Controller;

use App\Entity\Bill;
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
        $transactions = $this->getDoctrine()
            ->getRepository(Bill::class)
            ->findAllBills();

        return new JsonResponse($transactions);
    }
}
