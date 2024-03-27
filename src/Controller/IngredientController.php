<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{

/**
 * 
 * This method will show all ingredients in a row boostraped with KNP-pagination
 * 
 */

    #[Route('/ingredient', name: 'ingredient')]

    public function index(IngredientRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {


        $ingredients = $paginator->paginate(

            $repository->findAll(), /*c'est la query*/
            $request->query->getInt('page', 1),
            10 
        );


        return $this->render('pages/ingredient/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }

    #[Route('/ingredient/nouveau', name: 'ingredient.new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);


        return $this->render
        (
            'pages/ingredient/new.html.twig', ['form' => $form->createView()]
        );
    }
}
