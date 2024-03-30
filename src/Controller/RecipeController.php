<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\RecipeRepository;


class RecipeController extends AbstractController
{
    #[Route('/recipe', name: 'recipe_index')]
    public function index(RecipeRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        
        
        $recipes = $paginator->paginate(

            $repository->findAll(), /*c'est la query*/
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('pages/recipe/index.html.twig', [
            'recipes' => $recipes
        ]);
        
        
        


    }
}
