<?php

namespace App\Framework\Controller;

use App\Domain\RecipeIntegration\RecipeIntegrationManager;
use App\Domain\RecipeRender\RecipeRenderManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RecipeController extends Controller
{
    /**
     * @Route("/recipe/search")
     * @param Request $request
     * @return JsonResponse
     */
    public function searchAction(Request $request)
    {
        $page = $request->get('page');
        $query = $request->get('query');

        try {
            /**
             * @var $recipeManager RecipeIntegrationManager
             */
            $recipeManager = $this->container->get("app.recipe_integration");
            $entitiesRecipe = $recipeManager->findRecipes([], $query, $page);

        } catch (\Exception $ex) {

            $entitiesRecipe = [];
        }

        /**
         * @var $recipeRenderManager RecipeRenderManager
         */
        $recipeRenderManager = $this->container->get("app.recipe_render");

        return new JsonResponse($recipeRenderManager->renderRecipeEntities($entitiesRecipe));
    }
}