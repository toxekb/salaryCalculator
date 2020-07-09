<?php


namespace App\Service\Salary\CalculationHandlers;


use App\Service\Salary\Calculations\AgeBonus;
use App\Service\Salary\SalaryCalculation;

class AgeBonusCalculationHandler implements CalculationHandlerInterface
{
    public const BONUS_PERCENT = 7;

    public function calculate(SalaryCalculation $salaryCalculation): void
    {
        if ($salaryCalculation->getEmployee()->getAge() > 50) {
            $salary = $salaryCalculation->getEmployee()->getSalary();
            $salaryCalculation->addCalculation(new AgeBonus((self::BONUS_PERCENT / 100) * $salary));
        }
    }
}