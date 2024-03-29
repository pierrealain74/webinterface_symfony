<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientType;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{

    /**
     * 
     * This Controller will show all ingredients in a row boostraped with KNP-pagination
     * 
     */

    #[Route('/ingredient', name: 'ingredient.index')]

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


    /**
     * Controller to ADD Ingredient
     * 
     * 
     */


    #[Route('/ingredient/nouveau', name: 'ingredient.new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $manager): Response
    {
        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientType::class, $ingredient);

        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {

            //dd($form->getData());
            $ingredient = $form->getData();
            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                'success',
                'Ingredient correctement inséré :)'
            );

            return $this->redirectToRoute('ingredient.index');
        } else {

            $this->addFlash(
                'notice',
                'Ingredient déjà inséré ou donnée manquante :)'
            );
        }

        return $this->render
        (
            'pages/ingredient/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Controller to EDIT Ingredient
     * 
     * 
     */

    #[Route('/ingredient/edit/{id}', name: 'ingredient.edit', methods: ['GET', 'POST'])]
    public function edit(Ingredient $ingredient, Request $request, EntityManagerInterface $manager): Response
    {
        $form = $this->createForm(IngredientType::class, $ingredient);


        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {

            //dd($form->getData());
            $ingredient = $form->getData();
            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                'success',
                'Ingredient correctement modifié :)'
            );

            return $this->redirectToRoute('ingredient.index');
        } else {

            $this->addFlash(
                'notice',
                'Ingredient déjà modifié ou donnée manquante :)'
            );
        }




        return $this->render
        (
            'pages/ingredient/edit.html.twig',
            ['form' => $form->createView()]
        );
    }


/**
 * 
 * Delete un ingredient
 * 
 */

    #[Route('/ingredient/delete/{id}', name:'ingredient.delete', methods: ['GET', 'POST'])]
    public function delete(Ingredient $ingredient, EntityManagerInterface $manager): Response
    {
        $manager->remove($ingredient);
        $manager->flush();
    
        $this->addFlash(
            'success',
            'Ingredient supprimé avec succès :)'
        );
    
        return $this->redirectToRoute('ingredient.index');
    }



}
