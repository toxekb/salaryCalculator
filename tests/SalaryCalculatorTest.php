<?php

namespace App\Tests;

use App\Entity\Country;
use App\Entity\Employee;
use App\Service\Salary\CalculationHandlers\AgeBonusCalculationHandler;
use App\Service\Salary\CalculationHandlers\CarUsingDeductionCalculationHandler;
use App\Service\Salary\CalculationHandlers\TaxCalculationHandler;
use App\Service\Salary\SalaryCalculation;
use App\Service\Salary\SalaryCalculator;
use PHPUnit\Framework\TestCase;

class SalaryCalculatorTest extends TestCase
{
    /**
     * @dataProvider additionProvider
     * @param int $tax
     * @param int $age
     * @param $kidsNumber
     * @param bool $usingCar
     * @param int $bruttoSalary
     * @param int $netSalary
     */
    public function testCalculator(int $tax, int $age, $kidsNumber, bool $usingCar, int $bruttoSalary, int $netSalary)
    {
        $country = (new Country())->setTax($tax);
        $employee = (new Employee())
            ->setAge($age)
            ->setNumberOfKids($kidsNumber)
            ->setCountry($country)
            ->setUsingCompanyCar($usingCar)
            ->setSalary($bruttoSalary);
        $handlers = [
            new AgeBonusCalculationHandler(),
            new CarUsingDeductionCalculationHandler(),
            new TaxCalculationHandler()
        ];
        $calculator = new SalaryCalculator($handlers);

        $salaryCalculation = $calculator->calculateSalary($employee);

        $this->assertEquals($netSalary, $salaryCalculation->getCalculatedSalary());
    }

    public function additionProvider()
    {
        return [
            [20, 26, 2, false, 6000,4800],
            [20, 52, 0, true, 4000,3024],
            [20, 36, 3, true, 5000,3690],
        ];
    }
}
