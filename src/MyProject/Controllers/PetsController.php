<?php

namespace MyProject\Controllers;

use MyProject\Models\Pets\Pet;
use MyProject\Exceptions\NotFoundException;

class PetsController extends AbstractController
{
    /** Каталог питомцев с фильтром по виду (динамический элемент). */
    public function list(): void
    {
        $pets = Pet::findAll();

        // Фильтр по виду животного через GET-параметр species
        $species = $_GET['species'] ?? 'all';
        $allowed = ['all', 'cat', 'dog', 'other'];
        if (!in_array($species, $allowed, true)) {
            $species = 'all';
        }
        if ($species !== 'all') {
            $pets = array_values(array_filter($pets, function (Pet $p) use ($species) {
                return $p->getSpecies() === $species;
            }));
        }

        $this->render('pets/list.php', [
            'title'    => 'Наши питомцы — Лапки',
            'pets'     => $pets,
            'species'  => $species,
        ]);
    }

    /** Детальная страница одного питомца. */
    public function show(int $petId): void
    {
        $pet = Pet::getById($petId);
        if ($pet === null) {
            throw new NotFoundException('Питомец не найден');
        }

        $this->render('pets/show.php', [
            'title' => $pet->getName() . ' — Лапки',
            'pet'   => $pet,
        ]);
    }
}
