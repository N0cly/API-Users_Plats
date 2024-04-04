<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
class UserService
{
    private UserRepository $repository;
    private EntityManagerInterface $entityManager;

    public function __construct(UserRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }



    public function getAll(): array
    {
        $users = $this->repository->findAll();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'user_id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'isAdmin' => $user->isIsAdmin(),
                'adresse' => $user->getAdresse(),
                'telephone' => $user->getTelephone(),
            ];
        }
        return $data;
    }

    public function getUser(int $id): array
    {
        $user = $this->repository->find($id);
        if (!$user) {
            return [
                'status' => 'User not found',
            ];
        } else {
            return [
                'user_id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'isAdmin' => $user->isIsAdmin(),
                'adresse' => $user->getAdresse(),
                'telephone' => $user->getTelephone(),
            ];
        }
    }

    public function add(mixed $lastName, mixed $firstName, mixed $email, mixed $password, mixed $adresse, mixed $telephone): array
    {
        //verifie si l'email n'existe pas
        $user = $this->repository->findOneBy(['email' => $email]);
        if ($user) {
            return [
                'status' => 'User already exists',
            ];
        }
        //ajoute un utilisateur

        $user = new User();
        $user->setLastName($lastName);
        $user->setFirstName($firstName);
        $user->setEmail($email);

        // encrypte le mot de passe
        $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
        $user->setPassword($passwordHashed);

        $user->setAdresse($adresse);
        $user->setTelephone($telephone);
        $user->setIsAdmin(false);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
        return [
            'user_id' => $user->getId(),
            'lastName' => $user->getLastName(),
            'firstName' => $user->getFirstName(),
            'email' => $user->getEmail(),
            'isAdmin' => $user->isIsAdmin(),
            'adresse' => $user->getAdresse(),
            'telephone' => $user->getTelephone(),
        ];
    }

    public function update(int $id, mixed $lastName, mixed $firstName, mixed $email, mixed $password, mixed $adresse, mixed $telephone, mixed $isAdmin)
    {
        $user = $this->repository->find($id);

        if ($lastName) {
            $user->setLastName($lastName);
        }
        if ($firstName) {
            $user->setFirstName($firstName);
        }
        if ($email) {
            $user->setEmail($email);
        }
        if ($password) {
            // encrypte le mot de passe
            $passwordHashed = password_hash($password, PASSWORD_DEFAULT);
            $user->setPassword($passwordHashed);
        }
        if ($adresse) {
            $user->setAdresse($adresse);
        }
        if ($telephone) {
            $user->setTelephone($telephone);
        }
        if ($isAdmin) {
            $user->setIsAdmin($isAdmin);
        }

        $this->entityManager->flush();
        return [
            'user_id' => $user->getId(),
            'lastName' => $user->getLastName(),
            'firstName' => $user->getFirstName(),
            'email' => $user->getEmail(),
            'isAdmin' => $user->isIsAdmin(),
            'adresse' => $user->getAdresse(),
            'telephone' => $user->getTelephone(),
        ];
    }

    public function delete(int $id): array
    {
        $user = $this->repository->find($id);
        $this->entityManager->remove($user);
        $this->entityManager->flush();
        return [
            'status' => 'User deleted',
        ];
    }

    public function getUserByEmail(mixed $email): array
    {
        $user = $this->repository->findOneBy(['email' => $email]);
        if (!$user) {
            return [
                'status' => 'User not found',
            ];
        } else {
            return [
                'user_id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'isAdmin' => $user->isIsAdmin(),
                'adresse' => $user->getAdresse(),
                'telephone' => $user->getTelephone(),
            ];
        }
    }

    public function getUserByFirstName(mixed $firstName): array
    {
        $user = $this->repository->findOneBy(['firstName' => $firstName]);
        if (!$user) {
            return [
                'status' => 'User not found',
            ];
        } else {
            return [
                'user_id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'isAdmin' => $user->isIsAdmin(),
                'adresse' => $user->getAdresse(),
                'telephone' => $user->getTelephone(),
            ];
        }
    }

    public function getUserByLastName(mixed $lastName)
    {
        $user = $this->repository->findOneBy(['lastName' => $lastName]);
        if (!$user) {
            return [
                'status' => 'User not found',
            ];
        } else {
            return [
                'user_id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'isAdmin' => $user->isIsAdmin(),
                'adresse' => $user->getAdresse(),
                'telephone' => $user->getTelephone(),
            ];
        }
    }

    public function getUserByTelephone(mixed $telephone)
    {
        $user = $this->repository->findOneBy(['telephone' => $telephone]);
        if (!$user) {
            return [
                'status' => 'User not found',
            ];
        } else {
            return [
                'user_id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'isAdmin' => $user->isIsAdmin(),
                'adresse' => $user->getAdresse(),
                'telephone' => $user->getTelephone(),
            ];
        }
    }

    public function getUserByAdresse(mixed $adresse)
    {
        $user = $this->repository->findOneBy(['adresse' => $adresse]);
        if (!$user) {
            return [
                'status' => 'User not found',
            ];
        } else {
            return [
                'user_id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'isAdmin' => $user->isIsAdmin(),
                'adresse' => $user->getAdresse(),
                'telephone' => $user->getTelephone(),
            ];
        }
    }

    public function getAllAdmin(): array
    {
        $users = $this->repository->findBy(['isAdmin' => true]);
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'user_id' => $user->getId(),
                'lastName' => $user->getLastName(),
                'firstName' => $user->getFirstName(),
                'email' => $user->getEmail(),
                'isAdmin' => $user->isIsAdmin(),
                'adresse' => $user->getAdresse(),
                'telephone' => $user->getTelephone(),
            ];
        }
        return $data;
    }

    public function connectUser(mixed $email, mixed $password): array
    {
        $user = $this->repository->findOneBy(['email' => $email]);
        if (!$user) {
            return [
                'status' => 'User not found',
            ];
        } else {
            // vérifie si le mot de passe est correct
            if (password_verify($password, $user->getPassword())) {
                return [
                    'user_id' => $user->getId(),
                    'lastName' => $user->getLastName(),
                    'firstName' => $user->getFirstName(),
                    'email' => $user->getEmail(),
                    'isAdmin' => $user->isIsAdmin(),
                    'adresse' => $user->getAdresse(),
                    'telephone' => $user->getTelephone(),
                ];
            } else {
                return [
                    'status' => 'Wrong password',
                ];
            }
        }
    }


}