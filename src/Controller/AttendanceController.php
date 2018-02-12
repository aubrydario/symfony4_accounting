<?php

namespace App\Controller;

use App\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class AttendanceController extends Controller
{
    /**
     * @Route("/attendance", name="attendance")
     */
    public function attendanceAction() {
        return $this->render('default/attendance.html.twig');
    }

    /**
     * @Route("/api/attendance")
     * @Method("GET")
     */
    public function getAttendanceAction()
    {
        $bills = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findAllCustomerNameJoinBill();

        return new JsonResponse($bills);
    }
}