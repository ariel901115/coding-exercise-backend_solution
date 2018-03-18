<?php
/**
 * Created by PhpStorm.
 * User: arielgutierrez
 * Date: 17/3/18
 * Time: 21:50
 */

namespace App\tests\RecipeIntegration;

use App\Data\Entity\Recipe;
use App\Domain\RecipeIntegration\Wrapper\ApiRecipePuppyWrapper;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class ApiRecipePuppyWrapperTest extends TestCase
{
    public function testResponseOk()
    {
        $clientMock = $this->prepareClient();
        $wrapper = new ApiRecipePuppyWrapper($clientMock);

        $responseData = $clientMock->request('GET', '/');

        $reflection = new \ReflectionObject($wrapper);
        $method = $reflection->getMethod('isResponseOk');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($wrapper, $responseData));
    }

    public function testLoadData()
    {
        $clientMock = $this->prepareClient();
        $wrapper = new ApiRecipePuppyWrapper($clientMock);

        $reflection = new \ReflectionObject($wrapper);

        $method = $reflection->getMethod('loadData');
        $method->setAccessible(true);

        $dataRaw = $method->invoke($wrapper);

        $this->assertEquals(4, count($dataRaw));
    }

    public function testWrapperDataToEntitiesRecipe()
    {
        $clientMock = $this->prepareClient();
        $wrapper = new ApiRecipePuppyWrapper($clientMock);

        $reflection = new \ReflectionObject($wrapper);

        $method = $reflection->getMethod('wrapperDataToEntitiesRecipe');
        $method->setAccessible(true);

        $dataRaw = $this->getRecipeData();

        $entitiesRecipe = $method->invoke($wrapper, $dataRaw);

        $this->assertEquals(4, count($entitiesRecipe));

        foreach ($entitiesRecipe as $entity) {
            $this->assertTrue(($entity instanceof Recipe));
        }
    }

    private function prepareClient()
    {
        $body = [
            "title" => "Recipe Puppy",
            "version" => 0.1,
            "href" => "http://www.recipepuppy.com/",
            "results" => $this->getRecipeData()
        ];

        $mock = new MockHandler(
            [
                new Response(200, [], json_encode($body))
            ]
        );

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        return $client;
    }

    private function getRecipeData()
    {
        return [
            [
                "title" => "Shrimp &amp; Veggie Toss Over Pasta Recipe",
                "href" => "http:\/\/www.cdkitchen.com\/recipes\/recs\/1092\/Shrimp-Veggie-Toss-Over-Past94698.shtml",
                "ingredients" => "garlic, onions, peppers, shrimp, pasta",
                "thumbnail" => ""
            ],
            [
                "title" => "Veggie Dip",
                "href" => "http:\/\/www.cooks.com\/rec\/view\/0,171,148174-252193,00.html",
                "ingredients" => "yogurt, onions, parsley, dill weed, garlic",
                "thumbnail" => "",
            ],
            [
                "title" => "Easy Baked Veggie Pasta With Goat Cheese",
                "href" => "http:\/\/www.recipezaar.com\/Easy-Baked-Veggie-Pasta-With-Goat-Cheese-221256",
                "ingredients" => "alfredo sauce, dry pasta, garlic, goat cheese, mushroom, olive oil, onions, pesto, spinach, zucchini",
                "thumbnail" => "http:\/\/img.recipepuppy.com\/512470.jpg"
            ],
            [
                "title" => "Veggie Side Dish",
                "href" => "http:\/\/vegweb.com\/index.php?topic=10874.0",
                "ingredients" => "green pepper, onions, tomato, olive oil, garlic",
                "thumbnail" => "",
            ]
        ];
    }
}