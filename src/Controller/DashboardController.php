<?php

namespace App\Controller;

use App\Entity\Transaction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DashboardController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {
        $transactions = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findAllTransactions();

        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $jsonTransactions = $serializer->serialize($transactions, 'json');

        dump($jsonTransactions);

        return $this->render('default/dashboard.html.twig');
    }
}
