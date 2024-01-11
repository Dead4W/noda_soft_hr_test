<?php

namespace Dead4w\App\Requests;


use Dead4w\App\Enums\NotificationTypes;
use Dead4w\App\Exceptions\ModelNotFoundException;
use Dead4w\App\Exceptions\OperationValidation\ClientNotFoundException;
use Dead4w\App\Exceptions\OperationValidation\CreatorNotFoundException;
use Dead4w\App\Exceptions\OperationValidation\EmptyNotificationTypeException;
use Dead4w\App\Exceptions\OperationValidation\ExpertNotFoundException;
use Dead4w\App\Exceptions\OperationValidation\NotificationClientException;
use Dead4w\App\Exceptions\ValidationException;
use Dead4w\App\Exceptions\ValidationInvalidType;
use Dead4w\App\Repositories\ContractorRepository;
use Dead4w\App\Common\Request;

class ReferencesOperationRequest extends Request
{

    public function validate(): void {
        $contractorRepository = new ContractorRepository();

        try {
            $resellerId = $this->getInteger('resellerId');
            $this->data['reseller'] = $contractorRepository->getSellerByIdOrFail($resellerId);
        } catch (ValidationInvalidType|ModelNotFoundException $exception) {
            throw new NotificationClientException('Empty resellerId');
        }

        try {
            $clientId = $this->getInteger('clientId');
            $this->data['client'] = $contractorRepository->getContractorByIdOrFail($clientId);
        } catch (ValidationInvalidType|ModelNotFoundException $exception) {
            throw new ClientNotFoundException();
        }
        if ($this->data['client']->getSeller()->getId() === $resellerId) {
            throw new ClientNotFoundException('ClientId and ResellerId can\'t be same');
        }

        try {
            $creatorId = $this->getInteger('creatorId');
            $this->data['creator'] = $contractorRepository->getEmployeeByIdOrFail($creatorId);
        } catch (ValidationInvalidType|ModelNotFoundException $exception) {
            throw new CreatorNotFoundException();
        }

        try {
            $expertId = $this->getInteger('expertId');
            $this->data['expert'] = $contractorRepository->getEmployeeByIdOrFail($expertId);
        } catch (ValidationInvalidType|ModelNotFoundException $exception) {
            throw new ExpertNotFoundException();
        }

        $oldNotificationState = $this->get('differences.from', null);
        if ($oldNotificationState !== null) {
            $this->data['oldNotificationState'] = $this->getInteger('differences.from');
        }

        $newNotificationState = $this->get('differences.to', null);
        if ($newNotificationState !== null) {
            $this->data['newNotificationState'] = $this->getInteger('differences.to');
        }

        $notificationType = (int) $this->get('notificationType', 0);
        if (empty($notificationType)) {
            throw new EmptyNotificationTypeException();
        }

        if ($this->get('complaintId') !== null) {
            $complaintId = $this->getInteger('complaintId');
        }

        if ($this->get('consumptionId') !== null) {
            $consumptionId = $this->getInteger('consumptionId');
        }

        $checkToNotEmptyKeys = [
            'complaintId', 'complaintNumber', 'consumptionId',
            'consumptionNumber', 'agreementNumber', 'date',
        ];

        if ($notificationType === NotificationTypes::CHANGE) {
            $checkToNotEmptyKeys[] = 'differences';
            $checkToNotEmptyKeys[] = 'differences.from';
            $checkToNotEmptyKeys[] = 'differences.to';
        }

        foreach ($checkToNotEmptyKeys as $key) {
            if (empty($this->get($key, ''))) {
                throw new ValidationException("Param ($key) can't be empty");
            }
        }
    }

}