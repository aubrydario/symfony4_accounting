<?php

namespace App\Service;


use App\Entity\Customer;
use Doctrine\Common\Persistence\ObjectManager;

class SuccessMessage {
    protected $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    public function getSuccessMessage($request, $repository)
    {
        $item = $this->em->getRepository($repository)->find(intval($request->query->get('edit')));

        return $successMessage = [
            'type' => 'edit',
            'item' => $item
        ];
    }
}