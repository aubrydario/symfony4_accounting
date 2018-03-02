<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\Customer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AttendanceController extends Controller
{
    /**
     * @Route("/attendance", name="attendance")
     */
    public function attendance() {
        return $this->render('default/attendance.html.twig');
    }

    /**
     * @Route("/api/attendance")
     * @Method("GET")
     */
    public function getAttendance()
    {
        $bills = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findAllCustomerNameJoinBill();

        return new JsonResponse($bills);
    }

    /**
     * @Route("/api/attendanceDetails")
     * @Method({"GET", "POST"})
     */
    public function getAttendanceDetails(Request $request)
    {
        $bills = $this->getDoctrine()
            ->getRepository(Attendance::class)
            ->findAllAttendancesJoinBillJoinCustomer();

        return new JsonResponse($bills);
    }
}