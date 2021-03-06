<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Entity\User;
use App\Form\CustomerFormType;
use App\Service\SuccessMessage;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CustomersController extends AbstractController
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
     * @Route("/customers", name="customers")
     */
    public function customers(Request $request, PaginatorInterface $paginator) {
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
            $customer->setUser($em->getRepository(User::class)->find($this->getUser()->getId()));
            $em->persist($customer);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        // Get all Customers
        $query = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findAllCustomerQuerys($this->getUser()->getId());

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