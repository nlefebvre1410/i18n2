<?php

namespace Cz\AdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CarrouselControllerTest extends WebTestCase
{
    public function testCarrousel()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/carrousel');
    }

}
