<?php

namespace App\Tests;

use App\Entity\Country;
use App\Entity\Employee;
use App\Service\Salary\CalculationHandlers\AgeBonusCalculationHandler;
use App\Service\Salary\CalculationHandlers\CarUsingDeductionCalculationHandler;
use App\Service\Salary\SalaryCalculation;
use PHPUnit\Framework\TestCase;

class CarDeductionCalculationHandlerTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     * @param bool $usingCar
     * @param int $salary
     */
    public function testCarUsingDeduction(bool $usingCar,int $salary)
    {
        $country = (new Country())->setTax(10);
        $employee = (new Employee())
            ->setAge(20)
            ->setCountry($country)
            ->setUsingCompanyCar($usingCar)
            ->setSalary(1000);
        $salaryCalculation = new SalaryCalculation($employee);
        (new CarUsingDeductionCalculationHandler())->calculate($salaryCalculation);

        $this->assertEquals($salary,$salaryCalculation->getCalculatedSalary());
    }

    public function additionProvider()
    {
        return [
            [true, 500],
            [false, 1000]
        ];
    }
}
