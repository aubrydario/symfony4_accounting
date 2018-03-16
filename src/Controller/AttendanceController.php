<?php

namespace App\Controller;

use App\Entity\Abo;
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
     * @Method({"GET", "POST", "DELETE"})
     */
    public function attendanceDetails(Request $request)
    {
        if($request->getMethod() === 'GET') {
            $attendance = $this->getDoctrine()
                ->getRepository(Attendance::class)
                ->findAllAttendancesJoinBillJoinCustomer();

            return new JsonResponse($attendance);
        } else if($request->getMethod() === 'POST'){
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
        } else if($request->getMethod() === 'DELETE') {
            $data = (array)json_decode($request->getContent());

            $this->getDoctrine()->getRepository(Attendance::class)->deleteAttendance($data['id']);

            return new JsonResponse('he');
        }
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
            ->findAllHours();
        return new JsonResponse($hours);
    }
}