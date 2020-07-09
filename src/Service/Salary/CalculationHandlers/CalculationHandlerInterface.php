<?php


namespace App\Service\Salary\CalculationHandlers;


use App\Service\Salary\SalaryCalculation;

interface CalculationHandlerInterface
{
    public function calculate(SalaryCalculation $salaryCalculation): void;
}