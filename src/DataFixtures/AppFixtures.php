<?php

namespace App\DataFixtures;

use App\Entity\Family;
use App\Entity\Resident;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{

    private Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // Resident
        $residents = [];
        for ($i=0; $i < 50; $i++) { 
            $resident = new Resident();
            $resident->setFirstname($this->faker->firstName())
            ->setLastname($this->faker->lastname())
            ->setBirthday($this->faker->dateTime())
            ->setBirthPlace($this->faker->departmentName())
            ->setBirthCountry($this->faker->country())
            ->setNationality($this->faker->word())
            ->setEmail(mt_rand(0, 1) == 1 ? $this->faker->email() : 'N/A')
            ->setAddress($this->faker->address());

            $residents[] = $resident;
            $manager->persist($resident);
        }

        // Family
        for ($i=0; $i < 50; $i++) { 
            $family = new Family();
            $family->setName($this->faker->name())
            ->setHeadOfHousehold($this->faker->name())
            ->setAddress($this->faker->address())
            ->setCity($this->faker->city())
            ->setCountry($this->faker->country())
            ->setContact($this->faker->phoneNumber());

            for ($j=0; $j < mt_rand(1, 50); $j++) { 
                $family->addFamilyMember($residents[mt_rand(0, count($residents)-1)]);
            }

            $manager->persist($family);
        }

        $manager->flush();
    }

}
