<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number_of_kids;

    /**
     * @ORM\Column(type="boolean")
     */
    private $using_company_car;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="employees",cascade={"PERSIST"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $country;

    /**
     * @ORM\Column(type="float")
     */
    private $salary;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getNumberOfKids(): ?int
    {
        return $this->number_of_kids;
    }

    public function setNumberOfKids(?int $number_of_kids): self
    {
        $this->number_of_kids = $number_of_kids;

        return $this;
    }

    public function isUsingCompanyCar(): ?bool
    {
        return $this->using_company_car;
    }

    public function setUsingCompanyCar(bool $using_company_car): self
    {
        $this->using_company_car = $using_company_car;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): self
    {
        $this->salary = $salary;

        return $this;
    }
}
