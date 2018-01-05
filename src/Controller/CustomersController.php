<?php

namespace App\Controller;

//use AppBundle\Entity\Customer;
//use AppBundle\Form\CustomerFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\DateType;
//use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CustomersController extends Controller
{
    /**
     * @Route("/customers")
     */
    public function customersAction(Request $request) {
        $em = $this->getDoctrine()->getManager();
        $customers = $em->getRepository('App:Customer')->findAll();

        /*$form = $this->createForm(CustomerFormType::class);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();

            return $this->redirectToRoute('dashboard');
        }*/

        return $this->render('default/customers.html.twig', [
            'customers' => $customers,
            //'newCustomerForm' => $form->createView()
        ]);
    }
}