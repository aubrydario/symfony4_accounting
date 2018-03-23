<?php

namespace App\Controller;

use App\Entity\Payment;
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
            'editForm' => $editForm->createView()
        ]);
    }

    /**
     * @Route("/payment/delete/{id}")
     */
    public function deactivateCustomerAction($id) {
        $this->getDoctrine()
            ->getRepository(Payment::class)
            ->deletePayment($id);

        return $this->redirectToRoute('payment');
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
            $bill = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($bill);
            $em->flush();
            return $this->redirect($request->getUri());
        }

        $query = $this->getDoctrine()
            ->getRepository(Payment::class)
            ->findAllPaymentQuerys();

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