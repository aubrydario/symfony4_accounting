<?php

namespace App\Tests\Service;

use App\Entity\Customer;
use App\Service\SuccessMessage;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class SuccessMessageTest extends WebTestCase {

    private $em;

    protected function setUp() {
        $_ENV['KERNEL_CLASS'] = "App\Kernel";

        $kernel = self::bootKernel();

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testGetSuccessMessage() {
        $client = self::createClient();
        $client->request('GET', '/customers?edit=1');
        $request = $client->getRequest();

        $successMessage = new SuccessMessage($this->em);
        $result = $successMessage->getSuccessMessage($request, Customer::class);

        $this->assertEquals($result['item'], $this->em->getRepository(Customer::class)->find(1));
    }

    protected function tearDown()
    {
        parent::tearDown();

        $this->em->close();
        $this->em = null; // avoid memory leaks
    }
}
