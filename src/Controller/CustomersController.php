<?php

namespace App\Controller;

use App\Doctrine\PaginationHelper;
use App\Entity\Customer;
use App\Form\CustomerFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CustomersController extends Controller
{
    /**
     * @Route("/customers/edit/{id}")
     * @Route("/customers/page/customers/edit/{id}")
     * @Route("/customers/customers/edit/{id}")
     */
   public function editCustomer(Request $request, $id) {
       $user = $this->getDoctrine()->getRepository(Customer::class)->find($id);
       $editForm = $this->createForm(CustomerFormType::class, $user);
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
     * @Route("/customers/delete/{id}")
     * @Route("/customers/page/{page}/delete/{id}")
     */
    public function deactivateCustomer($id) {
        $this->getDoctrine()
            ->getRepository(Customer::class)
            ->deactivateCustomer($id);

        return $this->redirectToRoute('customers');
    }

    /**
     * @Route("/customers", name="customers")
     * @Route("/customers/page/{page}", name="customers_page")
     */
    public function customers(Request $request, $page = 1) {
        //dump($request->request->all());
        $form = $this->createForm(CustomerFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
        }

        // Get all Customers
        $query = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findAllCustomerQuerys();

        $pages = PaginationHelper::getPagesCount($query, 5);
        $customers = PaginationHelper::paginate($query, 5, $page);

        return $this->render('default/customers.html.twig', [
            'customers' => $customers,
            'page' => $page,
            'pages' => $pages,
            'newForm' => $form->createView()
        ]);
    }
}