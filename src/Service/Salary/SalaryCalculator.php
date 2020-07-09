<?php


namespace App\Service\Salary;


use App\Entity\Employee;
use App\Service\Salary\CalculationHandlers\CalculationHandlerInterface;

class SalaryCalculator implements SalaryCalculatorInterface
{
    /**
     * @var CalculationHandlerInterface[]
     */
    private $calculationHandlers = [];

    /**
     * SalaryCalculator constructor.
     * @param CalculationHandlerInterface[] $calculationHandlers
     */
    public function __construct(iterable $calculationHandlers)
    {
        $this->calculationHandlers = $calculationHandlers;
    }


    public function calculateSalary(Employee $employee): SalaryCalculation
    {
        $salaryCalculation = new SalaryCalculation($employee);
        foreach ($this->calculationHandlers as $calculationHandler) {
            $calculationHandler->calculate($salaryCalculation);
        }

        return $salaryCalculation;
    }
}