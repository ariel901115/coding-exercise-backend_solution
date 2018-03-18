<?php
/**
 * Created by PhpStorm.
 * User: arielgutierrez
 * Date: 17/3/18
 * Time: 14:14
 */

namespace App\Domain\RecipeIntegration\Wrapper;

class MockWrapper extends RecipeWrapperAbstract
{
    const RESPONSE_RESULT = "results";

    const RESPONSE_RESULT_INGREDIENTS = "ingredients";
    const RESPONSE_RESULT_TITLE = "title";
    const RESPONSE_RESULT_HREF = "href";
    const RESPONSE_RESULT_THUMBNAIL = "thumbnail";


    /**
     * @inheritdoc
     */
    protected function loadData($ingredients = [], $query = null, $page = 1)
    {
        return [
            [
                "title" => "Shrimp &amp; Veggie Toss Over Pasta Recipe",
                "href" => "http:\/\/www.cdkitchen.com\/recipes\/recs\/1092\/Shrimp-Veggie-Toss-Over-Past94698.shtml",
                "ingredients" => "garlic, onions, peppers, shrimp, pasta",
                "thumbnail" => ""
            ]
        ];
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
}