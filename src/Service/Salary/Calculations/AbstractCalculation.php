<?php


namespace App\Service\Salary\Calculations;


class AbstractCalculation
{
    protected $sum;
    protected $description;

    /**
     * AbstractCalculation constructor.
     * @param $sum
     */
    public function __construct(float $sum)
    {
        $this->sum = $sum;
    }

    /**
     * @return float
     */
    public function getSum(): float
    {
        return $this->sum;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }


}