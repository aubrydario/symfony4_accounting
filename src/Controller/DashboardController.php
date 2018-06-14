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
}
