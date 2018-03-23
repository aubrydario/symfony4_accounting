<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Entity\Customer;
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
    public function dashboard()
    {
        return $this->render('default/dashboard.html.twig');
    }

    /**
     * @Route("/api/customers")
     * @Method("GET")
     */
    public function getCustomers()
    {
        $customers = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findAllCustomerGroupedByGender();
        return new JsonResponse($customers);
    }

    /**
     * @Route("/api/bills")
     * @Method("GET")
     */
    public function getBills()
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
    public function getPayments()
    {
        $payments = $this->getDoctrine()
            ->getRepository(Payment::class)
            ->findAllPayments();

        return new JsonResponse($payments);
    }
}
