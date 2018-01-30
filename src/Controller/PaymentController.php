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