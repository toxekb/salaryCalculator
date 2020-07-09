<?php

namespace App\Command;

use App\Repository\EmployeeRepository;
use App\Service\Salary\Calculations\BonusCalculationInterface;
use App\Service\Salary\SalaryCalculatorInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CalculateSalaryCommand extends Command
{
    protected static $defaultName = 'calculate-salary';
    /**
     * @var SalaryCalculatorInterface
     */
    private $salaryCalculator;
    /**
     * @var EmployeeRepository
     */
    private $employeeRepository;

    /**
     * CalculateSalaryCommand constructor.
     * @param SalaryCalculatorInterface $salaryCalculator
     * @param EmployeeRepository $employeeRepository
     */
    public function __construct(SalaryCalculatorInterface $salaryCalculator, EmployeeRepository $employeeRepository)
    {
        parent::__construct();

        $this->salaryCalculator = $salaryCalculator;
        $this->employeeRepository = $employeeRepository;
    }


    protected function configure()
    {
        $this
            ->setDescription('Calculate salary')
            ->addArgument('employeeId', InputArgument::OPTIONAL, 'Id of Employee');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $employeeId = $input->getArgument('employeeId');

        $employeeList = [];
        if ($employeeId) {
            $employee = $this->employeeRepository->find($employeeId);
            if (!$employee) {
                $io->error(sprintf('Employee id is incorrect'));
                return 0;
            }
            $employeeList[] = $this->employeeRepository->find($employeeId);
        } else {
            $employeeList = $this->employeeRepository->findAll();
        }

        foreach ($employeeList as $employee) {
            $salaryCalculation = $this->salaryCalculator->calculateSalary($employee);
            $io->section($employee->getName());
            $io->write('Salary brutto: $' . $employee->getSalary(), true);
            foreach ($salaryCalculation->getCalculations() as $calculation) {
                $sign = $calculation instanceof BonusCalculationInterface ? '+' : '-';
                $io->write(sprintf('%s : %s$%s', $calculation->getDescription(), $sign, $calculation->getSum()), true);
            }
            $io->write('Salary net: $' . $salaryCalculation->getCalculatedSalary(), true);

        }

        $io->success('Done.');

        return 0;
    }
}
