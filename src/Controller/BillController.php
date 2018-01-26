<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Form\BillFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BillController extends Controller
{
    /**
     * @Route("/bill/delete/{id}")
     */
    public function deactivateCustomerAction($id) {
        $this->getDoctrine()
            ->getRepository(Bill::class)
            ->deleteBill($id);

        return $this->redirectToRoute('bill');
    }

    /**
     * @Route("/bill", name="bill")
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
            ->getRepository(Bill::class)
            ->findAllBills();

        return $this->render('default/bill.html.twig', [
            'bills' => $bills,
            'newForm' => $form->createView()
        ]);
    }
}