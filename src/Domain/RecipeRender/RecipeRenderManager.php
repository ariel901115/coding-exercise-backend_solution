<?php
/**
 * Created by PhpStorm.
 * User: arielgutierrez
 * Date: 17/3/18
 * Time: 17:20
 */

namespace App\Domain\RecipeRender;

use App\Data\Entity\Recipe;

class RecipeRenderManager
{
    /**
     * Devuelve la respuesta con las recetas dadas
     * @param $recipeEntities
     * @return array
     */
    public function renderRecipeEntities($recipeEntities)
    {
        $result = $this->prepareResult($recipeEntities);

        $response = array(
            "title" => "coding-exercise-backend",
            "version" => "0.1",
            "href" => "https://github.com/mo2o/coding-exercise-backend",
            "status" => 'OK',
            "results" => $result
        );

        return $response;
    }

    /**
     * Prepara las entidades de Recipe a un array
     * @param array $recipeEntities
     * @return array
     */
    private function prepareResult($recipeEntities = array())
    {
        $recipes = array();

        if (!empty($recipeEntities)) {
            foreach ($recipeEntities as $entity) {

                /**
                 * @var $entity Recipe
                 */
                $recipe['thumbnail'] = $entity->getThumbnail();
                $recipe['tags'] = $entity->getTags(); // Devuelvo tags porque la template de RunTasty lo necesita pero el RecipePuppy no nos lo da
                $recipe['title'] = $entity->getTitle();

                $recipes[] = $recipe;
            }
        }

        return $recipes;
    }
}