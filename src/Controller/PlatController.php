<?php

namespace App\Controller;

use App\Service\PlatService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/v1/plat', name:'plat')]
class PlatController extends AbstractController
{

    private PlatService $platService;

    public function __construct(PlatService $platService)
    {
        $this->platService = $platService;
    }

    // affiche tous les plats
    #[Route('/', name:'get_all_plat', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        return new JsonResponse($this->platService->getAll());
    }

    // affiche un plat
    #[Route('/{id}', name:'get_plat', methods: ['GET'])]
    public function getPlat(int $id): JsonResponse
    {
        return new JsonResponse($this->platService->getPlat($id));
    }

    // add plat
    #[Route('/', name:'add_plat', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->platService->add(
            $data['name'],
            $data['description'],
            $data['ingredient'],
            $data['quantite'],
            $data['prix'],
            $data['lien']
        ));
    }

    // update plat
    #[Route('/{id}', name:'update_plat', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        $name = $data['name'] ?? null;
        $description = $data['description'] ?? null;
        $ingredient = $data['ingredient'] ?? null;
        $quantite = $data['quantite'] ?? null;
        $prix = $data['prix'] ?? null;
        $lien = $data['lien'] ?? null;

        return new JsonResponse($this->platService->update($id, $name, $description, $ingredient, $quantite, $prix, $lien));
    }

    // delete plat
    #[Route('/{id}', name:'delete_plat', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        return new JsonResponse($this->platService->delete($id));
    }

    // get plat by ingredient, where ingredient in db is a json array
    #[Route('/ingredient/{ingredient}', name:'get_plat_by_ingredient', methods: ['GET'])]
    public function getPlatByIngredient(string $ingredient): JsonResponse
    {
        return new JsonResponse($this->platService->getPlatByIngredient($ingredient));
    }

    // get plat by prix max
    #[Route('/prix', name:'get_plat_by_prix', methods: ['POST'])]
    public function getPlatByPrix(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->platService->getPlatByPrix($data['prix']));
    }

    //get plat with prix max

    #[Route('/prixMax', name:'get_plat_by_prixmax', methods: ['POST'])]
    public function getPlatByPrixMax(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->platService->getPlatByPrixMax($data['prix']));
    }

    // get plat by name
    #[Route('/name', name:'get_plat_by_name', methods: ['POST'])]
    public function getPlatByName(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->platService->getPlatByName($data['name']));
    }

}