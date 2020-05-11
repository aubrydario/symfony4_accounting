<?php

namespace App\Controller;

use App\Entity\Abo;
use App\Entity\Attendance;
use App\Entity\Customer;
use App\Entity\Hour;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AttendanceController extends AbstractController
{
    /**
     * @Route("/attendance", name="attendance")
     */
    public function attendance() {
        $abos = $this->getDoctrine()->getRepository(Abo::class)->findBy(['user' => $this->getUser()->getId()]);

        return $this->render('default/attendance.html.twig', [
            'abos' => $abos
        ]);
    }

    /**
     * @Route("/api/attendance", methods={"GET"})
     */
    public function getAttendance()
    {
        $bills = $this->getDoctrine()
            ->getRepository(Customer::class)
            ->findAllCustomerNameJoinBill($this->getUser()->getId());

        return new JsonResponse($bills);
    }

    /**
     * @Route("/api/attendanceDetails", methods={"GET"})
     */
    public function attendanceDetails()
    {
        $attendance = $this->getDoctrine()
            ->getRepository(Attendance::class)
            ->findAllAttendancesJoinBillJoinCustomer($this->getUser()->getId());

        return new JsonResponse($attendance);
    }

    /**
     * @Route("/api/attendanceCount/{id}", name="attendanceCountById", methods={"GET"})
     * @Route("/api/attendanceCount", name="attendanceCount", methods={"GET"})
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
     * @Route("/api/hour", methods={"GET"})
     */
    public function getHour()
    {
        $hours = $this->getDoctrine()
            ->getRepository(Hour::class)
            ->findAllHours($this->getUser()->getId());
        return new JsonResponse($hours);
    }
}