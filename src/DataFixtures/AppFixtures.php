<?php

namespace App\DataFixtures;

use App\Entity\DateAnniversaire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 50; $i++) {
            $dateAnniversaire = new DateAnniversaire();
            $dateAnniversaire->setNom($this->generateRandomName());
            $dateAnniversaire->setPrenom($this->generateRandomFirstName());
            $dateAnniversaire->setDate($this->generateRandomDate());

            $manager->persist($dateAnniversaire);
        }

        $manager->flush();
    }

    private function generateRandomName(): string
    {
        $names = ['Dupond', 'Cross', 'Durand', 'Dubois', 'Hernandez', 'Griezmann', 'Wembanyama', 'James', 'Curry', 'Harden'];
        return $names[array_rand($names)];
    }

    private function generateRandomFirstName(): string
    {
        $firstNames = ['John', 'Alice', 'Bob', 'Emily', 'Michael', 'Emma', 'David', 'Olivia', 'Daniel', 'Sophia'];
        return $firstNames[array_rand($firstNames)];
    }

    private function generateRandomDate(): \DateTimeInterface
    {
        $startDate = new \DateTime('1950-01-01');
        $endDate = new \DateTime();
        $randomTimestamp = mt_rand($startDate->getTimestamp(), $endDate->getTimestamp());
        return new \DateTime(date('Y-m-d', $randomTimestamp));
    }
}
    
