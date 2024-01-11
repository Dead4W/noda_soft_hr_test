<?php

namespace Dead4w\App\Repositories;

use Dead4w\App\Exceptions\ModelNotFoundException;
use Dead4w\App\Models\Contractor;
use Dead4w\App\Models\Employee;
use Dead4w\App\Models\Seller;

class ContractorRepository
{

    public function getContractorById(int $id): ?Contractor
    {
        return new Contractor($id); // fakes the getById method
    }

    public function getSellerById(int $id): ?Seller
    {
        return new Seller($id); // fakes the getById method
    }

    public function getEmployeeById(int $id): ?Employee
    {
        return new Employee($id); // fakes the getById method
    }

    public function getContractorByIdOrFail(int $id): Contractor
    {
        if ($id === 0) {
            // fakes not found
            throw new ModelNotFoundException(Contractor::class, $id);
        }

        return $this->getContractorById($id);
    }

    public function getSellerByIdOrFail(int $id): Seller
    {
        if ($id === 0) {
            // fakes not found
            throw new ModelNotFoundException(Seller::class, $id);
        }

        return $this->getSellerById($id);
    }

    public function getEmployeeByIdOrFail(int $id): Employee
    {
        if ($id === 0) {
            // fakes not found
            throw new ModelNotFoundException(Employee::class, $id);
        }

        return $this->getEmployeeById($id);
    }

}