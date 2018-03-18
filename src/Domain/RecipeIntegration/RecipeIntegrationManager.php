<?php

namespace App\Domain\RecipeIntegration;

use App\Domain\RecipeIntegration\Wrapper\RecipeWrapperAbstract;

class RecipeIntegrationManager
{
    /**
     * @var RecipeWrapperAbstract
     */
    private $wrapper;

    public function __construct(RecipeWrapperAbstract $wrapper)
    {
        $this->wrapper = $wrapper;
    }

    /**
     * Hace la busqueda de recetas
     * @param array $ingredients
     * @param null $query
     * @param int $page
     * @return array
     */
    public function findRecipes($ingredients = [], $query = null, $page = 1)
    {
        return $this->wrapper->find($ingredients, $query, $page);
    }

}