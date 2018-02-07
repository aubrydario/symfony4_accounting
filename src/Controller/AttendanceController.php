<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AttendanceController extends Controller
{
    /**
     * @Route("/attendance", name="attendance")
     */
    public function attendanceAction() {
        return $this->render('default/attendance.html.twig');
    }
}