<?php

namespace App\Controller;

use App\Entity\Hour;
use App\Entity\User;
use App\Form\HourFormType;
use App\Service\SuccessMessage;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HourController extends Controller
{
    /**
     * @Route("/hour/edit/{id}")
     */
    public function editHour(Request $request, $id) {
        $user = $this->getDoctrine()->getRepository(Hour::class)->find($id);
        $editForm = $this->createForm(HourFormType::class, $user);
        $editForm->handleRequest($request);
        if($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect('/hour?edit=' . $id);
        }

        return $this->render('default/editForm.html.twig', [
            'editForm' => $editForm->createView(),
            'site' => 'hour'
        ]);
    }

    /**
     * @Route("/hour", name="hour")
     */
    public function hour(Request $request)
    {
        $successMessage = null;
        if($request->query->get('hour')) {
            $sm = new SuccessMessage($this->getDoctrine()->getManager());
            $successMessage = $sm->getSuccessMessage($request, Hour::class);
        }

        $form = $this->createForm(HourFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $hour = $form->getData();
            $hour->setUser($em->getRepository(User::class)->find($this->getUser()->getId()));
            $em->persist($hour);
            $em->flush();
            return $this->redirect($request->getUri());
        }

        $query = $this->getDoctrine()
            ->getRepository(Hour::class)
            ->findAllHourQuerys($this->getUser()->getId());

        $paginator = $this->get('knp_paginator');
        $hours = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            $request->query->get('limit', 20)
        );

        return $this->render('default/hour.html.twig', [
            'hours' => $hours,
            'newForm' => $form->createView(),
            'successMessage' => $successMessage
        ]);
    }
}