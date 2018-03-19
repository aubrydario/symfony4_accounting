<?php

namespace App\Controller;

use App\Doctrine\PaginationHelper;
use App\Entity\Bill;
use App\Form\BillFormType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BillController extends Controller
{
    /**
     * @Route("/bill/edit/{id}")
     * @Route("/bill/page/bill/edit/{id}")
     * @Route("/bill/bill/edit/{id}")
     */
    public function editCustomer(Request $request, $id) {
        $user = $this->getDoctrine()->getRepository(Bill::class)->find($id);
        $editForm = $this->createForm(BillFormType::class, $user);
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
     * @Route("/bill/delete/{id}")
     * @Route("/bill/page/{page}/delete/{id}")
     */
    public function deactivateCustomerAction($id) {
        $this->getDoctrine()
            ->getRepository(Bill::class)
            ->deleteBill($id);

        return $this->redirectToRoute('bill');
    }

    /**
     * @Route("/bill", name="bill")
     * @Route("/bill/page/{page}", name="bill_page")
     */
    public function billAction(Request $request, $page = 1)
    {
        $form = $this->createForm(BillFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $bill = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($bill);
            $em->flush();
        }

        $query = $this->getDoctrine()
            ->getRepository(Bill::class)
            ->findAllBillQuerys();

        $pages = PaginationHelper::getPagesCount($query, 5);
        $bills = PaginationHelper::paginate($query, 5, $page);

        return $this->render('default/bill.html.twig', [
            'bills' => $bills,
            'page' => $page,
            'pages' => $pages,
            'newForm' => $form->createView()
        ]);
    }
}