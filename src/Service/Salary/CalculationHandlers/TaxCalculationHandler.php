<?php


namespace App\Service\Salary\CalculationHandlers;


use App\Service\Salary\Calculations\Tax;
use App\Service\Salary\SalaryCalculation;

class TaxCalculationHandler implements CalculationHandlerInterface
{

    public function calculate(SalaryCalculation $salaryCalculation): void
    {
        //get base tax
        $tax = $salaryCalculation->getEmployee()->getCountry()->getTax();

        //check for tax deduction for kids
        if ($salaryCalculation->getEmployee()->getNumberOfKids() > 2) {
            $tax -= 2;
        }

        $salary = $salaryCalculation->getCalculatedSalary();
        $salaryCalculation->addCalculation(new Tax($salary * ($tax / 100)));
    }
}