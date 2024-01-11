<?php

namespace Dead4w\App\Models;

use Dead4w\App\Enums\ContractorTypes;

class Contractor
{

    protected int $id;
    protected int $type;
    protected string $name;
    protected string $email;
    protected string $mobile;
    protected ?Seller $seller;

    public function __construct(int $id) {
        // MOCK DATA
        $this->id = $id;
        $this->type = ContractorTypes::CUSTOMER;
        $this->name = 'Ilya';
        $this->email = 'contractor@example.com';
        $this->mobile = '+79111111111';

        if (static::class === Contractor::class) {
            $this->seller = new Seller($id + 10);
        }
    }

    public function getMobile(): string
    {
        return $this->mobile;
    }

    public function getSeller(): ?Seller
    {
        return $this->seller;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return $this->name . ' ' . $this->id;
    }

}