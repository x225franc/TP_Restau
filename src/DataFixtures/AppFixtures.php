<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Restaurant;
use App\Entity\RestaurantTable;
use App\Entity\Menu;
use App\Entity\Reservation;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Faker\Factory;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $usersData = [
            ['email' => 'user@user.com', 'roles' => ['ROLE_USER']],
            ['email' => 'admin@admin.com', 'roles' => ['ROLE_ADMIN']],
            ['email' => 'banni@banni.com', 'roles' => ['ROLE_BANNED']],
        ];

        foreach ($usersData as $userData) {
            $user = new User();
            $user->setEmail($userData['email']);
            $user->setRoles($userData['roles']);
            $user->setPassword($this->passwordHasher->hashPassword($user, '123'));
            $user->setFirstName($faker->firstName);
            $user->setLastName($faker->lastName);
            $manager->persist($user);
        }

        $restaurants = [];
        for ($i = 0; $i < 5; $i++) {
            $restaurant = new Restaurant();
            $restaurant->setName($faker->company);
            $restaurant->setAddress($faker->address);
            $restaurant->setCity($faker->city);
            $restaurant->setCapacity($faker->numberBetween(50, 200));
            $manager->persist($restaurant);
            $restaurants[] = $restaurant;
        }

        $tables = [];
        foreach ($restaurants as $restaurant) {
            for ($i = 0; $i < 10; $i++) {
                $table = new RestaurantTable();
                $table->setNumber($i + 1);
                $table->setSeats($faker->numberBetween(2, 8));
                $table->setRestaurant($restaurant);
                $manager->persist($table);
                $tables[] = $table;
            }
        }

        foreach ($restaurants as $restaurant) {
            for ($i = 0; $i < 5; $i++) {
                $menu = new Menu();
                $menu->setName($faker->word);
                $menu->setDescription($faker->sentence);
                $menu->setPrice($faker->randomFloat(2, 10, 100));
                $menu->setRestaurant($restaurant);
                $manager->persist($menu);
            }
        }

        foreach ($tables as $table) {
            for ($i = 0; $i < 3; $i++) {
                $reservation = new Reservation();
                $reservation->setDate($faker->dateTimeBetween('-1 month', '+1 month'));
                $reservation->setGuestCount($faker->numberBetween(1, $table->getSeats()));
                $reservation->setTable($table);
                $reservation->setRestaurant($table->getRestaurant());
                $manager->persist($reservation);
            }
        }

        $manager->flush();
    }
}
