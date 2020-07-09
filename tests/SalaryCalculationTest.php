<?php

namespace App\Tests;

use App\Entity\Country;
use App\Entity\Employee;
use App\Service\Salary\Bonus;
use App\Service\Salary\CalculationHandlers\AgeBonusCalculationHandler;
use App\Service\Salary\CalculationHandlers\CarUsingDeductionCalculationHandler;
use App\Service\Salary\CalculationHandlers\TaxCalculationHandler;
use App\Service\Salary\Calculations\AbstractCalculation;
use App\Service\Salary\Calculations\BonusCalculationInterface;
use App\Service\Salary\Calculations\DeductionCalculationInterface;
use App\Service\Salary\Deduction;
use App\Service\Salary\SalaryCalculation;
use App\Service\Salary\SalaryCalculator;
use PHPUnit\Framework\TestCase;

class SalaryCalculationTest extends TestCase
{
    protected $calculation;
    protected function setUp()
    {
        $this->calculation = new SalaryCalculation(
            (new Employee())
                ->setAge(20)
                ->setNumberOfKids(2)
                ->setCountry((new Country())->setTax(10))
                ->setUsingCompanyCar(false)
                ->setSalary(100)
        );;
    }

    public function testCalculationDeduction()
    {
        $testClass = new class(50) extends AbstractCalculation implements DeductionCalculationInterface {
            protected $description = 'Test deduction';
        };
        $this->calculation->addCalculation($testClass);
        $this->assertCount(1, $this->calculation->getCalculations());
        $this->assertInstanceOf(DeductionCalculationInterface::class, $this->calculation->getCalculations()[0]);
        $this->assertEquals(50, $this->calculation->getCalculations()[0]->getSum());
        $this->assertEquals('Test deduction', $this->calculation->getCalculations()[0]->getDescription());
        $this->assertEquals(50, $this->calculation->getCalculatedSalary());
    }

    public function testCalculationBonus()
    {
        $testClass = new class(50) extends AbstractCalculation implements BonusCalculationInterface {
            protected $description = 'Test bonus';
        };
        $this->calculation->addCalculation($testClass);
        $this->assertCount(1, $this->calculation->getCalculations());
        $this->assertInstanceOf(BonusCalculationInterface::class, $this->calculation->getCalculations()[0]);
        $this->assertEquals(50, $this->calculation->getCalculations()[0]->getSum());
        $this->assertEquals('Test bonus', $this->calculation->getCalculations()[0]->getDescription());
        $this->assertEquals(150, $this->calculation->getCalculatedSalary());
    }
}
