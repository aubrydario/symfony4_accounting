<?php

namespace App\Controller;

use App\Entity\Transaction;
use App\Form\BillFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BillController extends Controller
{
    /**
     * @Route("/bill")
     */
    public function billAction(Request $request)
    {
        $form = $this->createForm(BillFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $bill = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($bill);
            $em->flush();
        }

        $bills = $this->getDoctrine()
            ->getRepository(Transaction::class)
            ->findAllTransactions();

        return $this->render('default/bill.html.twig', [
            'bills' => $bills,
            'newBillForm' => $form->createView()
        ]);
    }
}