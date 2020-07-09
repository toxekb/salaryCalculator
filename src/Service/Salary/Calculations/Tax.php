<?php


namespace App\Service\Salary\Calculations;


class Tax extends AbstractCalculation implements DeductionCalculationInterface
{
    protected $description = 'Tax';
}