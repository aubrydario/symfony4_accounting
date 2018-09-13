<?php

namespace App\Controller;

use App\Entity\Abo;
use App\Entity\User;
use App\Form\AboFormType;
use App\Service\SuccessMessage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class AboController extends Controller
{
    /**
     * @Route("/abo/edit/{id}")
     */
    public function editAbo(Request $request, $id) {
        $user = $this->getDoctrine()->getRepository(Abo::class)->find($id);
        $editForm = $this->createForm(AboFormType::class, $user);
        $editForm->handleRequest($request);
        if($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirect('/abo?edit=' . $id);
        }

        return $this->render('default/editForm.html.twig', [
            'editForm' => $editForm->createView(),
            'site' => 'abo'
        ]);
    }

    /**
     * @Route("/abo", name="abo")
     */
    public function abo(Request $request)
    {
        $successMessage = null;
        if ($request->query->get('abo')) {
            $sm = new SuccessMessage($this->getDoctrine()->getManager());
            $successMessage = $sm->getSuccessMessage($request, Abo::class);
        }

        $form = $this->createForm(AboFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $abo = $form->getData();
            $abo->setUser($em->getRepository(User::class)->find($this->getUser()->getId()));
            $em->persist($abo);
            $em->flush();
            return $this->redirect($request->getUri());
        }

        $query = $this->getDoctrine()
            ->getRepository(Abo::class)
            ->findAllAboQuerys($this->getUser()->getId());

        $paginator = $this->get('knp_paginator');
        $abos = $paginator->paginate(
            $query,
            $request->query->get('page', 1),
            $request->query->get('limit', 20)
        );

        return $this->render('default/abo.html.twig', [
            'abos' => $abos,
            'newForm' => $form->createView(),
            'successMessage' => $successMessage
        ]);
    }
}
