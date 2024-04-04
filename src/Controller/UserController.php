<?php

namespace App\Controller;

use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/api/v1/user', name:'user')]
class UserController extends AbstractController
{

    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // affiche tous les utilisateurs
    #[Route('/', name:'get_all_user', methods: ['GET'])]
    public function getAll(): JsonResponse
    {
        return new JsonResponse($this->userService->getAll());
    }

    // affiche un utilisateur
    #[Route('/{id}', name:'get_user', methods: ['GET'])]
    public function findUser(int $id): JsonResponse
    {
        return new JsonResponse($this->userService->getUser($id));
    }

    // add utilisateur
    #[Route('/', name:'add_user', methods: ['POST'])]
    public function add(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->userService->add(
            $data['lastName'],
            $data['firstName'],
            $data['email'],
            $data['password'],
            $data['adresse'],
            $data['telephone']
        ));
    }

    // update utilisateur
    #[Route('/{id}', name:'update_user', methods: ['PUT'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        $lastName = $data['lastName'] ?? null;
        $firstName = $data['firstName'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;
        $adresse = $data['adresse'] ?? null;
        $telephone = $data['telephone'] ?? null;
        $admin = $data['isAdmin'] ?? null;

        return new JsonResponse($this->userService->update($id, $lastName, $firstName, $email, $password, $adresse, $telephone, $admin));
    }

    // delete utilisateur
    #[Route('/{id}', name:'delete_user', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        return new JsonResponse($this->userService->delete($id));
    }

    // get user by email
    #[Route('/email', name:'get_user_by_email', methods: ['POST'])]
    public function getUserByEmail(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->userService->getUserByEmail($data['email']));
    }

    //get user by firstName
    #[Route('/firstName', name:'get_user_by_firstName', methods: ['POST'])]
    public function getUserByFirstName(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->userService->getUserByFirstName($data['firstName']));
    }

    //get user by lastName
    #[Route('/lastName', name:'get_user_by_lastName', methods: ['POST'])]
    public function getUserByLastName(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->userService->getUserByLastName($data['lastName']));
    }

    //get user by telephone
    #[Route('/telephone', name:'get_user_by_telephone', methods: ['POST'])]
    public function getUserByTelephone(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->userService->getUserByTelephone($data['telephone']));
    }

    //get user by adresse
    #[Route('/adresse', name:'get_user_by_adresse', methods: ['POST'])]
    public function getUserByAdresse(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->userService->getUserByAdresse($data['adresse']));
    }

    //get admin
    #[Route('/admin/all', name:'get_all_admin', methods: ['GET'])]
    public function getAdmin(): JsonResponse
    {
        return new JsonResponse($this->userService->getAllAdmin());
    }

    //connect user
    #[Route('/connect', name:'connect_user', methods: ['POST'])]
    public function connectUser(Request $request): JsonResponse
    {
        $jsonString = $request->getContent();

        // Décoder la chaîne JSON en un tableau associatif PHP
        $data = json_decode($jsonString, true);

        return new JsonResponse($this->userService->connectUser($data['email'], $data['password']));
    }


}