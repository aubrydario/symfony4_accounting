<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Form\PaymentFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
    /**
     * @Route("/payment")
     */
    public function billAction(Request $request)
    {
        $form = $this->createForm(PaymentFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $bill = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($bill);
            $em->flush();
        }

        $em = $this->getDoctrine()->getManager();
        $payments = $em->getRepository(Payment::class)->findAll();

        return $this->render('default/payment.html.twig', [
            'payments' => $payments,
            'newPaymentForm' => $form->createView()
        ]);
    }
}