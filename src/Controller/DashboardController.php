<?php

namespace App\Controller;

use App\Entity\Transaction;
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
     * @Route("/api/transactions")
     * @Method("GET")
     */
    public function getTransactionsAction()
    {
        $transactions = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findAllTransactions();

        return new JsonResponse($transactions);
    }
}
