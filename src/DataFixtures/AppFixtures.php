<?php

namespace App\DataFixtures;

use App\Entity\Country;
use App\Entity\Employee;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $country = (new Country())->setTax(20)->setName('Russia');
        $employeeList = [
            [
                'name'       => 'Alice',
                'age'        => 26,
                'salary'     => 6000,
                'usingCar'   => false,
                'kidsNumber' => 2
            ],
            [
                'name'       => 'Bob',
                'age'        => 52,
                'salary'     => 4000,
                'usingCar'   => true,
                'kidsNumber' => 0
            ],
            [
                'name'       => 'Charlie',
                'age'        => 36,
                'salary'     => 5000,
                'usingCar'   => true,
                'kidsNumber' => 3
            ],
        ];
        foreach ($employeeList as $employeeData) {
            $manager->persist(
                (new Employee())
                    ->setAge($employeeData['age'])
                    ->setName($employeeData['name'])
                    ->setCountry($country)
                    ->setUsingCompanyCar($employeeData['usingCar'])
                    ->setNumberOfKids($employeeData['kidsNumber'])
                    ->setSalary($employeeData['salary'])
            );
        }

        $manager->flush();
    }
}
