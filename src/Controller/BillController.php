<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Form\BillFormType;
use App\Service\SuccessMessage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BillController extends Controller
{
    /**
     * @Route("/bill/edit/{id}")
     */
    public function editCustomer(Request $request, $id) {
        $user = $this->getDoctrine()->getRepository(Bill::class)->find($id);
        $editForm = $this->createForm(BillFormType::class, $user);
        $editForm->handleRequest($request);
        if($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect('/bill?edit=' . $id);
        }

        return $this->render('default/editForm.html.twig', [
            'editForm' => $editForm->createView()
        ]);
    }

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
        $successMessage = null;
        if($request->query->get('edit')) {
            $sm = new SuccessMessage($this->getDoctrine()->getManager());
            $successMessage = $sm->getSuccessMessage($request, Bill::class);
        }

        $form = $this->createForm(BillFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $bill = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($bill);
            $em->flush();
            return $this->redirect($request->getUri());
        }

        $query = $this->getDoctrine()
            ->getRepository(Bill::class)
            ->findAllBillQuerys();

        $paginator = $this->get('knp_paginator');
        $bills = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            $request->query->get('limit', 20)
        );

        return $this->render('default/bill.html.twig', [
            'bills' => $bills,
            'newForm' => $form->createView(),
            'successMessage' => $successMessage
        ]);
    }
}