<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserController extends Controller
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
