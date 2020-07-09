<?php


namespace App\Service\Salary\CalculationHandlers;


use App\Service\Salary\Calculations\CarUsingDeduction;
use App\Service\Salary\SalaryCalculation;

class CarUsingDeductionCalculationHandler implements CalculationHandlerInterface
{
    public const DEDUCTION_SUM = 500;

    public function calculate(SalaryCalculation $salaryCalculation): void
    {
        if ($salaryCalculation->getEmployee()->isUsingCompanyCar()) {
            $salaryCalculation->addCalculation(new CarUsingDeduction(self::DEDUCTION_SUM));
        }
    }
}