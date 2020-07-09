<?php


namespace App\Service\Salary;


use App\Entity\Employee;

interface SalaryCalculatorInterface
{
    public function calculateSalary(Employee $employee): SalaryCalculation;
}