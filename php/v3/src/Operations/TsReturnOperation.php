<?php

namespace Dead4w\App\Operations;


use Dead4w\App\Dtos\MessageDto;
use Dead4w\App\Dtos\ReferencesOperationDto;
use Dead4w\App\Dtos\ReferencesOperationResultDto;
use Dead4w\App\Enums\Events;
use Dead4w\App\Enums\NotificationEvents;
use Dead4w\App\Enums\NotificationTypes;
use Dead4w\App\Enums\Status;
use Dead4w\App\Exceptions\NotifySendException;
use Dead4w\App\Exceptions\OperationValidation\TemplateDataIsEmpty;
use Dead4w\App\Services\MessagesClient;
use Dead4w\App\Services\NotificationManager;


function __(...$args) {
    // fakes translate function
    return 'Title';
}


class TsReturnOperation extends ReferencesOperation
{

    public function doOperation(ReferencesOperationDto $data): ReferencesOperationResultDto
    {
        $result = new ReferencesOperationResultDto();

        $templateData = $this->generateTemplateData($data);

        // Если хоть одна переменная для шаблона не задана, то не отправляем уведомления
        foreach ($templateData as $key => $tempData) {
            if (empty($tempData)) {
                throw new TemplateDataIsEmpty($key);
            }
        }

        // Отправляем уведомление сотрудникам
        $emailFrom = $data->reseller->getEmail();
        if (!empty($emailFrom)) {
            $emailsTo = $this->getEmailsByPermit($data->reseller->getId(), Events::TS_GOODS_RETURN);
            if (count($emailsTo) > 0) {
                $this->sendEmails($emailFrom, $emailsTo, $templateData, $data->reseller->getId());
                $result->notificationEmployeeByEmail = true;
            }
        }

        // Отправляем уведомление клиенту, только если произошла смена статуса
        if ($data->notificationType === NotificationTypes::CHANGE && $data->newStatusState !== null) {
            if (!empty($emailFrom) && !empty($data->client->getEmail())) {
                $this->sendUserEmail($emailFrom, $templateData, $data);
                $result['notificationClientByEmail'] = true;
            }

            if (!empty($data->client->getMobile())) {
                try {
                    $res = NotificationManager::send(
                        contractorId:       $data->reseller->getId(),
                        secondContractorId: $data->client->getId(),
                        event:              NotificationEvents::CHANGE_RETURN_STATUS,
                        payload:            $data->newStatusState,
                        templateData:       $templateData,
                    );

                    $result->notificationClientBySmsIsSend = $res;
                } catch (NotifySendException $exception) {
                    $result->notificationClientBySmsError = $exception;
                }
            }
        }

        return $result;
    }

    protected function sendUserEmail(
        string $emailFrom,
        array $templateData,
        ReferencesOperationDto $data,
    ): void {
        $messages = [
            new MessageDto(
                emailFrom: $emailFrom,
                emailTo:   $data->client->getEmail(),
                subject:   __('complaintClientEmailSubject', $templateData, $data->reseller->getId()),
                message:   __('complaintClientEmailBody', $templateData, $data->reseller->getId()),
            )
        ];

        MessagesClient::sendMessage(
            messages:           $messages,
            contractorId:       $data->reseller->getId(),
            secondContractorId: $data->client->getId(),
            event:              NotificationEvents::CHANGE_RETURN_STATUS,
            payload:            $data->newStatusState,
        );
    }

    protected function sendEmails(
        string $emailFrom,
        array $emailsTo,
        array $templateData,
        int $resellerId,
    ): void {
        foreach ($emailsTo as $emailTo) {
            $messages = [
                new MessageDto(
                    emailFrom: $emailFrom,
                    emailTo:   $emailTo,
                    subject:   __('complaintEmployeeEmailSubject', $templateData, $resellerId),
                    message:   __('complaintEmployeeEmailBody', $templateData, $resellerId),
                ),
            ];

            MessagesClient::sendMessage(
                messages:     $messages,
                contractorId: $resellerId,
                event:        NotificationEvents::CHANGE_RETURN_STATUS
            );
        }
    }

    protected function generateTemplateData(ReferencesOperationDto $data): array
    {
        $differenceTitle = '';
        if ($data->notificationType === NotificationTypes::NEW) {
            $differenceTitle = __('NewPositionAdded', null, $data->reseller->getId());
        } elseif ($data->notificationType === NotificationTypes::CHANGE) {
            if ($data->oldStatusState !== null && $data->newStatusState !== null) {
                $differenceTitle = __('PositionStatusHasChanged', [
                    'FROM' => Status::getNameByState($data->oldStatusState),
                    'TO' => Status::getNameByState($data->newStatusState),
                ],                    $data->reseller->getId());
            }
        }

        $clientFullName = $data->client->getFullName();
        if (empty($clientFullName)) {
            $clientFullName = $data->client->getName();
        }

        $templateData = [
            'COMPLAINT_ID' => $data->complaintId,
            'COMPLAINT_NUMBER' => $data->complaintNumber,
            'CREATOR_ID' => $data->creator->getId(),
            'CREATOR_NAME' => $data->creator->getFullName(),
            'EXPERT_ID' => $data->expert->getId(),
            'EXPERT_NAME' => $data->expert->getFullName(),
            'CLIENT_ID' => $data->client->getId(),
            'CLIENT_NAME' => $clientFullName,
            'CONSUMPTION_ID' => $data->consumptionId,
            'CONSUMPTION_NUMBER' => $data->consumptionNumber,
            'AGREEMENT_NUMBER' => $data->agreementNumber,
            'DATE' => $data->date,
            'DIFFERENCES' => $differenceTitle,
        ];

        return $templateData;
    }

    protected function getEmailsByPermit(int $resellerId, string $event)
    {
        // fakes the method
        return ['someemeil@example.com', 'someemeil2@example.com'];
    }
}