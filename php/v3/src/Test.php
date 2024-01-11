<?php

namespace Dead4w\App;

require_once '../vendor/autoload.php';

use Dead4w\App\Dtos\ReferencesOperationDto;
use Dead4w\App\Enums\NotificationTypes;
use Dead4w\App\Operations\TsReturnOperation;
use Dead4w\App\Requests\ReferencesOperationRequest;

function dd($data) {
    var_dump($data);
    exit();
}

function resolve($className) {
    return new $className();
}

$test = new ReferencesOperationRequest(
    [
        'resellerId' => 1,
        'clientId' => 2,
        'creatorId' => 3,
        'expertId' => 4,
        'notificationType' => NotificationTypes::NEW,
        'complaintId' => 6,
        'complaintNumber' => '123-456',
        'consumptionId' => 7,
        'consumptionNumber' => 'aaa-bbb',
        'agreementNumber' => 'ccc-ddd',
        'date' => '2023-01-01',
    ]
);
$test->validate();

$inputDto = new ReferencesOperationDto(
    reseller: $test->get('reseller'),
    client: $test->get('client'),
    creator: $test->get('creator'),
    expert: $test->get('expert'),
    notificationType: $test->get('notificationType'),
    oldStatusState: $test->get('oldStatusState'),
    newStatusState: $test->get('newStatusState'),
    complaintId: $test->get('complaintId'),
    complaintNumber: $test->get('complaintNumber'),
    consumptionId: $test->get('consumptionId'),
    consumptionNumber: $test->get('consumptionNumber'),
    agreementNumber: $test->get('agreementNumber'),
    date: $test->get('date'),
);

$operation = new TsReturnOperation();

$result = $operation->doOperation($inputDto);

var_dump($result);