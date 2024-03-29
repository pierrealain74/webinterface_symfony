<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


use App\Entity\Ingredient;

use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class TestController extends AbstractController
{
    #[Route('/test', 'home.index', methods: ['GET', 'POST'])]
    

    public function index(IngredientRepository $repository, Request $request): Response
    {


        $ingredients = $repository->findAll();

        


        return $this->render('pages/test/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }

    

}
