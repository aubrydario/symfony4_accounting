<?php

namespace App\Controller;

use App\Entity\Bill;
use App\Form\BillFormType;
use App\Form\EditBillFormType;
use App\Service\SuccessMessage;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BillController extends AbstractController
{
    /**
     * @Route("/bill/receipt/{id}")
     */
    public function getReceipt($id, \Knp\Snappy\Pdf $snappy) {
        $bill = $this->getDoctrine()->getRepository(Bill::class)->findBillAndAboAndUserAndCustomer($this->getUser()->getId(), $id);

        $html = $this->renderView('components/receipt.html.twig', array(
            'user' => $this->getUser()->getFirstname() . ' ' . $this->getUser()->getLastname(),
            'bill' => $bill[0],
        ));

        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="receipt.pdf"'
            )
        );
    }

    /**
     * @Route("/bill/edit/{id}")
     */
    public function editCustomer(Request $request, $id) {
        $user = $this->getDoctrine()->getRepository(Bill::class)->find($id);
        $editForm = $this->createForm(EditBillFormType::class, $user);
        $editForm->handleRequest($request);
        if($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect('/bill?edit=' . $id);
        }

        return $this->render('default/editForm.html.twig', [
            'editForm' => $editForm->createView(),
            'site' => 'bill'
        ]);
    }

    /**
     * @Route("/bill/expired", name="bill-expired")
     */
    public function billExpired(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $this->getDoctrine()
            ->getRepository(Bill::class)
            ->findBillsQuery($this->getUser()->getId(), false);

        $bills = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            $request->query->get('limit', 20)
        );

        return $this->render('default/bill.html.twig', [
            'bills' => $bills,
            'successMessage' => null,
            'newForm' => null
        ]);
    }

    /**
     * @Route("/bill", name="bill")
     */
    public function billAction(Request $request, PaginatorInterface $paginator)
    {
        $em = $this->getDoctrine()->getManager();

        $successMessage = null;
        if($request->query->get('edit')) {
            $sm = new SuccessMessage($em);
            $successMessage = $sm->getSuccessMessage($request, Bill::class);
        }

        $form = $this->createForm(BillFormType::class, ['user' => $this->getUser()->getId()]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $maxDays = $form->get('abo')->getData()->getMaxDays();
            $date = $form->get('date')->getData();

            $enddate = clone $date;
            //$maxDays = $maxDays > 7 ? $maxDays - 7 : $maxDays;
            $data['enddate'] = $enddate->modify('+'. $maxDays . ' days');

            // Transform Array to Entity
            $bill = new Bill();
            $bill->setCustomer($data['customer']);
            $bill->setAbo($data['abo']);
            $bill->setDate($data['date']);
            $bill->setEnddate($data['enddate']);

            $em->persist($bill);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        $query = $this->getDoctrine()
            ->getRepository(Bill::class)
            ->findBillsQuery($this->getUser()->getId());

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
