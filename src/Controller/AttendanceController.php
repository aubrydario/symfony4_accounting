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
            ->findAllCustomerNameJoinBill();

        return new JsonResponse($bills);
    }

    /**
     * @Route("/api/attendanceDetails")
     * @Method({"GET", "POST"})
     */
    public function attendanceDetails(Request $request)
    {
        if($request->getMethod() === 'GET') {
            $attendance = $this->getDoctrine()
                ->getRepository(Attendance::class)
                ->findAllAttendancesJoinBillJoinCustomer();

            return new JsonResponse($attendance);
        } else {
            $data = (array)json_decode($request->getContent());

            $em = $this->getDoctrine()->getManager();

            $bill = $em->getRepository(Bill::class)->find($data['bill_id']);
            $hour = $em->getRepository(Hour::class)->find($data['hour_id']);

            $newAttendance = new Attendance();
            $newAttendance->setBill($bill);
            $newAttendance->setDate(new \DateTime($data['date']));
            $newAttendance->setHour($hour);

            $em->persist($newAttendance);
            $em->flush();

            return new JsonResponse($newAttendance);
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
            ->findAllHours();
        return new JsonResponse($hours);
    }
}