<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerFormType;
use App\Service\SuccessMessage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CustomersController extends Controller
{
    /**
     * @Route("/customers/edit/{id}")
     */
    public function editCustomer(Request $request, $id) {
       $user = $this->getDoctrine()->getRepository(Customer::class)->find($id);
       $editForm = $this->createForm(CustomerFormType::class, $user);
       $editForm->handleRequest($request);
       if($editForm->isSubmitted() && $editForm->isValid()) {
           $em = $this->getDoctrine()->getManager();
           $em->flush();
           return $this->redirect('/customers?edit=' . $id);
       }

       return $this->render('default/editForm.html.twig', [
           'editForm' => $editForm->createView(),
           'site' => 'customers'
       ]);
    }

    /**
     * @Route("/customers/delete/{id}")
     */
    public function deactivateCustomer($id) {
        $this->getDoctrine()
            ->getRepository(Customer::class)
            ->deactivateCustomer($id);

        return $this->redirectToRoute('customers');
    }

    /**
     * @Route("/customers", name="customers")
     */
    public function customers(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $successMessage = null;
        if($request->query->get('edit')) {
            $sm = new SuccessMessage($em);
            $successMessage = $sm->getSuccessMessage($request, Customer::class);
        }

        $form = $this->createForm(CustomerFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $customer->setActive(1);
            $em->persist($customer);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        // Get all Customers
        $query = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findAllCustomerQuerys();

        $paginator = $this->get('knp_paginator');
        $customers = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            $request->query->get('limit', 20)
        );

        return $this->render('default/customers.html.twig', [
            'customers' => $customers,
            'newForm' => $form->createView(),
            'successMessage' => $successMessage
        ]);
    }
}