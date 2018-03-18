<?php
/**
 * Created by PhpStorm.
 * User: arielgutierrez
 * Date: 17/3/18
 * Time: 14:14
 */

namespace App\Domain\RecipeIntegration\Wrapper;

use \GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class ApiRecipePuppyWrapper extends RecipeWrapperAbstract
{
    const STATUS_200 = 200;
    const RESPONSE_RESULT = "results";

    const RESPONSE_RESULT_INGREDIENTS = "ingredients";
    const RESPONSE_RESULT_TITLE = "title";
    const RESPONSE_RESULT_HREF = "href";
    const RESPONSE_RESULT_THUMBNAIL = "thumbnail";

    protected $client;

    /**
     * RecipeApiWrapper constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritdoc
     */
    protected function loadData($ingredients = [], $query = null, $page = 1)
    {
        $queryString = [
            'query' => [
                'p' => $page,
                'q' => $query
            ]
        ];

        try {

            $results = [];

            $responseData = $this->client->request('GET', '/api', $queryString);

            if ($this->isResponseOk($responseData)) {

                $content = json_decode($responseData->getBody()->getContents(), true);
                $results = $content[self::RESPONSE_RESULT];
            }

        } catch (\Exception $ex) {
            $results = [];
        }

        return $results;
    }

    /**
     * @inheritdoc
     */
    protected function wrapperDataToEntitiesRecipe($recipesRaw = [])
    {
        $entitiesRecipe = [];

        if (!empty($recipesRaw)) {
            foreach ($recipesRaw as $recipe) {
                $ingredients = $recipe[self::RESPONSE_RESULT_INGREDIENTS];
                $title = $recipe[self::RESPONSE_RESULT_TITLE];
                $href = $recipe[self::RESPONSE_RESULT_HREF];
                $thumbnail = $recipe[self::RESPONSE_RESULT_THUMBNAIL];

                $entitiesRecipe[] = $this->fillEntityRecipe($ingredients, $title, $href, $thumbnail);
            }
        }

        return $entitiesRecipe;
    }

    /**
     * @param ResponseInterface $response
     * @return bool
     */
    private function isResponseOk(ResponseInterface $response)
    {
        return $response->getStatusCode() == self::STATUS_200;
    }
}