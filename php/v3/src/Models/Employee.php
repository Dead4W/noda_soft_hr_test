<?php

namespace Dead4w\App\Models;

class Employee extends Contractor
{

    public function __construct(int $id) {
        parent::__construct($id);

        $this->name = 'Employeename';
        $this->email = 'employee@example.com';
    }

}