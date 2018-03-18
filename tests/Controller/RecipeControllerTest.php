<?php
/**
 * Created by PhpStorm.
 * User: arielgutierrez
 * Date: 18/3/18
 * Time: 10:11
 */

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RecipeControllerTest extends WebTestCase
{
    public function testSearch()
    {
        $client = static::createClient();

        $client->request('GET', '/recipe/search');
        $response = $client->getResponse();

        $this->assertEquals(200, $response->getStatusCode());

        $responseRaw = json_decode($response->getContent(), true);

        $this->assertTrue(isset($responseRaw["title"]));
        $this->assertTrue(isset($responseRaw["version"]));
        $this->assertTrue(isset($responseRaw["href"]));
        $this->assertTrue(isset($responseRaw["status"]));
        $this->assertTrue(isset($responseRaw["results"]));

        $this->assertEquals(1, $this->count($responseRaw["results"]));
    }
}