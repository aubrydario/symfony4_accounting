<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/activeUser", name="user")
     */
    public function index()
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findActiveUser($this->getUser()->getId());

        return new JsonResponse($user);
    }
}
