<?php

namespace App\Controller;

use App\Entity\Attendance;
use App\Entity\Bill;
use App\Entity\Customer;
use App\Entity\Hour;
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
            ->findAllCustomerNameJoinBill($this->getUser()->getId());

        return new JsonResponse($bills);
    }

    /**
     * @Route("/api/attendanceDetails")
     * @Method("GET")
     */
    public function attendanceDetails()
    {
        $attendance = $this->getDoctrine()
            ->getRepository(Attendance::class)
            ->findAllAttendancesJoinBillJoinCustomer($this->getUser()->getId());

        return new JsonResponse($attendance);
    }

    /**
     * @Route("/api/attendanceCount/{id}", name="attendanceCountById")
     * @Route("/api/attendanceCount", name="attendanceCount")
     * @Method("GET")
     */
    public function getAttendanceCount($id = null)
    {
        if(!$id) {
            $abos = $this->getDoctrine()
                ->getRepository(Attendance::class)
                ->findAllAttendanceCountJoinAbo();
            return new JsonResponse($abos);
        } else {
            $abos = $this->getDoctrine()
                ->getRepository(Attendance::class)
                ->findByBillIdAttendanceCountJoinAbo($id);
            return new JsonResponse($abos);
        }
    }

    /**
     * @Route("/api/hour")
     * @Method("GET")
     */
    public function getHour()
    {
        $hours = $this->getDoctrine()
            ->getRepository(Hour::class)
            ->findAllHours($this->getUser()->getId());
        return new JsonResponse($hours);
    }
}