<?php

namespace App\Service;

use App\Entity\Plats;
use App\Repository\PlatsRepository;
use Doctrine\ORM\EntityManagerInterface;
class PlatService
{

    private PlatsRepository $repository;
    private EntityManagerInterface $entityManager;

    public function __construct(PlatsRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function getAll(): array
    {
        $plats = $this->repository->findAll();
        $data = [];
        foreach ($plats as $plat) {
            $data[] = [
                'plat_id' => $plat->getId(),
                'name' => $plat->getName(),
                'description' => $plat->getDescription(),
                'ingredient' => $plat->getIngredients(),
                'quantite' => $plat->getQuantite(),
                'prix' => $plat->getPrix(),
                'lien' => $plat->getLien(),
            ];
        }
        return $data;

    }

    public function add(mixed $name, mixed $description, mixed $ingredient, mixed $quantite, mixed $prix, mixed $lien): array
    {
        $plat = new Plats();
        $plat->setName($name);
        $plat->setDescription($description);
        $plat->setIngredients($ingredient);
        $plat->setQuantite($quantite);
        $plat->setPrix($prix);
        $plat->setLien($lien);

        $this->entityManager->persist($plat);
        $this->entityManager->flush();

        return [
            'plat_id' => $plat->getId(),
            'name' => $plat->getName(),
            'description' => $plat->getDescription(),
            'ingredient' => $plat->getIngredients(),
            'quantite' => $plat->getQuantite(),
            'prix' => $plat->getPrix(),
            'lien' => $plat->getLien(),
        ];
    }

    public function getPlat(int $id)
    {
        $plat = $this->repository->find($id);
        if (!$plat) {
            return [
                'status' => 'Plat not found',
            ];
        } else {
            return [
                'plat_id' => $plat->getId(),
                'name' => $plat->getName(),
                'description' => $plat->getDescription(),
                'ingredient' => $plat->getIngredients(),
                'quantite' => $plat->getQuantite(),
                'prix' => $plat->getPrix(),
                'lien' => $plat->getLien(),
            ];
        }
    }

    public function update(int $id, mixed $name, mixed $description, mixed $ingredient, mixed $quantite, mixed $prix, mixed $lien): array
    {
        $plat = $this->repository->find($id);

        if ($name) {
            $plat->setName($name);
        }
        if ($description) {
            $plat->setDescription($description);
        }
        if ($ingredient) {
            $plat->setIngredients($ingredient);
        }
        if ($quantite) {
            $plat->setQuantite($quantite);
        }
        if ($prix) {
            $plat->setPrix($prix);
        }
        if ($lien) {
            $plat->setLien($lien);
        }

        $this->entityManager->flush();

        return [
            'plat_id' => $plat->getId(),
            'name' => $plat->getName(),
            'description' => $plat->getDescription(),
            'ingredient' => $plat->getIngredients(),
            'quantite' => $plat->getQuantite(),
            'prix' => $plat->getPrix(),
            'lien' => $plat->getLien(),
        ];
    }

    public function delete(int $id): array
    {
        $plat = $this->repository->find($id);
        if (!$plat) {
            return [
                'status' => 'Plat not found',
            ];
        }
        $this->entityManager->remove($plat);
        $this->entityManager->flush();
        return [
            'status' => 'Plat deleted',
        ];
    }


    public function getPlatByIngredient(string $ingredient): array
    {
        // get plat by ingredient, where ingredient in db is a json array

        $plats = $this->getAll();

        foreach ($plats as $plat) {
            //return plat even if the ingredient is written separately
            if (in_array($ingredient, $plat['ingredient'])) {
                $data[] = $plat;
            }

        }
        if (empty($data)) {
            // set the first lettre of the ingredient to uppercase
            $ingredient = ucfirst($ingredient);
            foreach ($plats as $plat) {
                if (in_array($ingredient, $plat['ingredient'])) {
                    $data[] = $plat;
                }
            }

        }
        if (empty($data)) {
            return [
                'status' => 'Plat not found',
            ];
        } else {
            return $data;
        }
    }


    public function getPlatByPrix(mixed $prix): array
    {
        // get all plats with a price less than or equal to the given price
        $plats = $this->repository->findBy(['prix' => $prix]);
        $data = [];
        foreach ($plats as $plat) {
            $data[] = [
                'plat_id' => $plat->getId(),
                'name' => $plat->getName(),
                'description' => $plat->getDescription(),
                'ingredient' => $plat->getIngredients(),
                'quantite' => $plat->getQuantite(),
                'prix' => $plat->getPrix(),
                'lien' => $plat->getLien(),
            ];
        }
        return $data;
    }

    public function getPlatByPrixMax(mixed $prix)
    {
        $plats = $this->getAll();
        $data = [];
        foreach ($plats as $plat) {
            if ($plat['prix'] <= $prix) {
                $data[] = $plat;
            }
        }
        if (empty($data)) {
            return [
                'status' => 'Plat not found',
            ];
        } else {
            // sort the array by price
            usort($data, function ($a, $b) {
                return $a['prix'] <=> $b['prix'];
            });
            return $data;
        }
    }

    public function getPlatByName(mixed $name): array
    {
        //research by name, return plat even if the name is written separately

        $plats = $this->getAll();
        $data = [];
        foreach ($plats as $plat) {
            if (str_contains($plat['name'], $name)) {
                $data[] = $plat;
            }
        }
        if (empty($data)) {
            // set the first lettre of the plat to uppercase
            $name = ucfirst($name);
            foreach ($plats as $plat) {
                if (str_contains($plat['name'], $name)) {
                    $data[] = $plat;
                }
            }

        } else {
            return $data;

        }
        if (empty($data)) {
            return [
                'status' => 'Plat not found',
            ];
        } else {
            return $data;
        }

    }
}