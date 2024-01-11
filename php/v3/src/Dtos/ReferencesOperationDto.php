<?php

namespace Dead4w\App\Dtos;


use DateTime;
use Dead4w\App\Models\Contractor;
use Dead4w\App\Models\Employee;
use Dead4w\App\Models\Seller;

class ReferencesOperationDto
{

    public function __construct(
        public Seller $reseller,
        public Contractor $client,
        public Employee $creator,
        public Employee $expert,

        public int $notificationType,
        public ?int $oldStatusState,
        public ?int $newStatusState,

        public ?int $complaintId,
        public ?string $complaintNumber,

        public ?int $consumptionId,
        public ?string $consumptionNumber,
        public ?string $agreementNumber,
        public ?string $date,
    ) {
    }

}