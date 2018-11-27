<?php

namespace Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RestAuthControllerTest extends WebTestCase
{
    protected $client;

    public function setUp()
    {
        parent::setUp();
    }

    public function testRestAuthAction()
    {
        $this->client = static::createClient();

        $this->client->request(
            'POST',
            '/rest/auth',
            [
                'email'    => 'test1@mail.com',
                'password' => '1234'
            ]
        );

        $this->assertTrue($this->client->getResponse()->getStatusCode() === 200);
        $this->assertJson($this->client->getResponse()->getContent());
    }
}