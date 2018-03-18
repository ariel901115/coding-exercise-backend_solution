<?php
/**
 * Created by PhpStorm.
 * User: arielgutierrez
 * Date: 17/3/18
 * Time: 14:14
 */

namespace App\Domain\RecipeIntegration\Wrapper;

use App\Data\Entity\Recipe;

abstract class RecipeWrapperAbstract
{
    /**
     * Hace la busqueda de recetas en funcion de los parametros dados
     * @param array $ingredients
     * @param null $query
     * @param int $page
     * @return array
     */
    public function find($ingredients = [], $query = null, $page = 1)
    {
        $dataRaw = $this->loadData($ingredients, $query, $page);
        return $this->wrapperDataToEntitiesRecipe($dataRaw);
    }

    /**
     * Hace la carga de datos
     * @param $ingredients
     * @param $title
     * @param $page
     * @return mixed
     */
    abstract protected function loadData($ingredients, $title, $page);

    /**
     * Hace Wrapper de las recetas que viene en crudo, devolviendo un array de entidades de tipo Recipe
     * @param array $recipesRaw
     * @return mixed
     */
    abstract protected function wrapperDataToEntitiesRecipe($recipesRaw = array());

    /**
     * Devuelve una entidad tipo Recipe con los valores pasados por argumento
     * @param null $ingredients
     * @param null $title
     * @param null $href
     * @param null $thumbnail
     * @return Recipe
     */
    protected function fillEntityRecipe($ingredients = null, $title = null, $href = null, $thumbnail = null)
    {
        $recipeEntity = new Recipe();
        $recipeEntity->setIngredients($ingredients);
        $recipeEntity->setThumbnail($thumbnail);
        $recipeEntity->setTitle($title);
        $recipeEntity->setHref($href);

        return $recipeEntity;
    }
}