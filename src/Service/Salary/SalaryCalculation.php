<?php


namespace App\Service\Salary;


use App\Entity\Employee;
use App\Service\Salary\Calculations\AbstractCalculation;
use App\Service\Salary\Calculations\BonusCalculationInterface;
use App\Service\Salary\Calculations\DeductionCalculationInterface;

class SalaryCalculation
{
    /**
     * @var AbstractCalculation[]
     */
    private $calculations = [];

    /**
     * @var Employee
     */
    private $employee;

    /**
     * SalaryCalculation constructor.
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function addCalculation(AbstractCalculation $calculation)
    {
        $this->calculations[] = $calculation;
    }

    /**
     * @return AbstractCalculation[]
     */
    public function getCalculations(): array
    {
        return $this->calculations;
    }

    public function getCalculatedSalary(): float
    {
        $salary = $this->employee->getSalary();
        foreach ($this->calculations as $calculation) {
            if ($calculation instanceof BonusCalculationInterface) {
                $salary += $calculation->getSum();
            } else {
                $salary -= $calculation->getSum();
            }
        }

        return $salary;
    }

    /**
     * @return Employee
     */
    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    /**
     * @return BonusCalculationInterface[]
     */
    public function getBonuses(): array
    {
        return array_filter(
            $this->calculations,
            function (AbstractCalculation $calculation) {
                return $calculation instanceof BonusCalculationInterface;
            }
        );
    }

    /**
     * @return DeductionCalculationInterface[]
     */
    public function getDeductions(): array
    {
        return array_filter(
            $this->calculations,
            function (AbstractCalculation $calculation) {
                return $calculation instanceof DeductionCalculationInterface;
            }
        );
    }
}