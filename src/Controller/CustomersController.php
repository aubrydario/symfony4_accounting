<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\CustomerFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CustomersController extends Controller
{
    /**
     * @Route("/customers")
     */
    public function customersAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $customers = $em->getRepository('App:Customer')->findAll();

        $form = $this->createForm(CustomerFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }

        return $this->render('default/customers.html.twig', [
            'customers' => $customers,
            'newCustomerForm' => $form->createView()
        ]);
    }
}