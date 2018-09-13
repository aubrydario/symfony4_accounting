<?php

namespace App\Controller;

use App\Entity\Payment;
use App\Entity\User;
use App\Form\PaymentFormType;
use App\Service\SuccessMessage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
    /**
     * @Route("/payment/edit/{id}")
     */
    public function editCustomer(Request $request, $id) {
        $user = $this->getDoctrine()->getRepository(Payment::class)->find($id);
        $editForm = $this->createForm(PaymentFormType::class, $user);
        $editForm->handleRequest($request);
        if($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect('/payment?edit=' . $id);
        }

        return $this->render('default/editForm.html.twig', [
            'editForm' => $editForm->createView(),
            'site' => 'payment'
        ]);
    }

    /**
     * @Route("/payment", name="payment")
     */
    public function billAction(Request $request)
    {
        $successMessage = null;
        if($request->query->get('edit')) {
            $sm = new SuccessMessage($this->getDoctrine()->getManager());
            $successMessage = $sm->getSuccessMessage($request, Payment::class);
        }

        $form = $this->createForm(PaymentFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $payment = $form->getData();
            $payment->setUser($em->getRepository(User::class)->find($this->getUser()->getId()));
            $em->persist($payment);
            $em->flush();
            return $this->redirect($request->getUri());
        }

        $query = $this->getDoctrine()
            ->getRepository(Payment::class)
            ->findAllPaymentQuerys($this->getUser()->getId());

        $paginator = $this->get('knp_paginator');
        $payments = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            $request->query->get('limit', 20)
        );

        return $this->render('default/payment.html.twig', [
            'payments' => $payments,
            'newForm' => $form->createView(),
            'successMessage' => $successMessage
        ]);
    }
}