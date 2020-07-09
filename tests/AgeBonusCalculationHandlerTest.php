<?php

namespace App\Tests;

use App\Entity\Country;
use App\Entity\Employee;
use App\Service\Salary\CalculationHandlers\AgeBonusCalculationHandler;
use App\Service\Salary\SalaryCalculation;
use PHPUnit\Framework\TestCase;

class AgeBonusCalculationHandlerTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     * @param int $age
     * @param int $salary
     */
    public function testAgeBonus(int $age,int $salary)
    {
        $country = (new Country())->setTax(10);
        $employee = (new Employee())
            ->setAge($age)
            ->setCountry($country)
            ->setSalary(100);
        $salaryCalculation = new SalaryCalculation($employee);
        (new AgeBonusCalculationHandler())->calculate($salaryCalculation);

        $this->assertEquals($salary,$salaryCalculation->getCalculatedSalary());
    }

    public function additionProvider()
    {
        return [
            [20, 100],
            [55, 107]
        ];
    }
}
