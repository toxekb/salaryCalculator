<?php


namespace App\Service\Salary\Calculations;


class CarUsingDeduction extends AbstractCalculation implements DeductionCalculationInterface
{
    protected $description = 'Using company car';
}