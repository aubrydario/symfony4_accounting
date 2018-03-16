<?php

namespace App\Controller;

use App\Doctrine\PaginationHelper;
use App\Entity\Payment;
use App\Form\PaymentFormType;
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
        }

        return $this->render('default/editForm.html.twig', [
            'editForm' => $editForm->createView()
        ]);
    }

    /**
     * @Route("/payment/delete/{id}")
     * @Route("/payment/page/{page}/delete/{id}")
     */
    public function deactivateCustomerAction($id) {
        $this->getDoctrine()
            ->getRepository(Payment::class)
            ->deletePayment($id);

        return $this->redirectToRoute('payment');
    }

    /**
     * @Route("/payment", name="payment")
     * @Route("/payment/page/{page}", name="payment_page")
     */
    public function billAction(Request $request, $page = 1)
    {
        $form = $this->createForm(PaymentFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $bill = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($bill);
            $em->flush();
        }

        $query = $this->getDoctrine()
            ->getRepository(Payment::class)
            ->findAllPaymentQuerys();

        $pages = PaginationHelper::getPagesCount($query, 5);
        $payments = PaginationHelper::paginate($query, 5, $page);

        return $this->render('default/payment.html.twig', [
            'payments' => $payments,
            'page' => $page,
            'pages' => $pages,
            'newForm' => $form->createView()
        ]);
    }
}