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
     * @Route("/customers/delete/{id}")
     */
    public function deactivateCustomerAction($id) {
        $this->getDoctrine()
            ->getRepository(Customer::class)
            ->deactivateCustomer($id);

        return $this->redirectToRoute('customers');
    }

    /**
     * @Route("/customers", name="customers")
     * @Route("/customers/page/{page}", name="customers_page")
     */
    public function customersAction(Request $request, $page = 1) {
        $form = $this->createForm(CustomerFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $customer = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
        }

        //$em = $this->getDoctrine()->getManager();
        //$customers = $em->getRepository('App:Customer')->findBy(['active' => 1]);

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