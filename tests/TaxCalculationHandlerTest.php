<?php

namespace App\Tests;

use App\Entity\Country;
use App\Entity\Employee;
use App\Service\Salary\CalculationHandlers\AgeBonusCalculationHandler;
use App\Service\Salary\CalculationHandlers\CarUsingDeductionCalculationHandler;
use App\Service\Salary\CalculationHandlers\TaxCalculationHandler;
use App\Service\Salary\SalaryCalculation;
use PHPUnit\Framework\TestCase;

class TaxCalculationHandlerTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     * @param int $tax
     * @param $kidsNumber
     * @param int $salary
     */
    public function testTax(int $tax, $kidsNumber, int $salary)
    {
        $country = (new Country())->setTax($tax);
        $employee = (new Employee())
            ->setAge(20)
            ->setNumberOfKids($kidsNumber)
            ->setCountry($country)
            ->setSalary(100);
        $salaryCalculation = new SalaryCalculation($employee);
        (new TaxCalculationHandler())->calculate($salaryCalculation);

        $this->assertEquals($salary, $salaryCalculation->getCalculatedSalary());
    }

    public function additionProvider()
    {
        return [
            [10,1, 90],
            [20,1, 80],
            [20,3, 82],
        ];
    }
}
