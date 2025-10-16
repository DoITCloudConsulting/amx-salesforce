<?php


namespace Amx\Salesforce\Objects\Standard;

use Amx\Salesforce\Traits\Standard\SFAccountFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFCase extends SFBaseObject
{
    protected string $sObject = 'Case';

    public function createCase(array $caseData, SFAccount $issuer, SFAccount $applicant): SFCase | array | null
    {
        if (empty($issuer->Id) || empty($applicant->Id)) {
            throw new \InvalidArgumentException("The SFAccount objects must contain valid Id values.");
        }

        $newCase = $this->create([
            ...$caseData,
            "case" => [
                ...$caseData["case"],
                "status" => "Nuevo",
            ],
        ]);

        if (!empty($caseData['Status'])) {
            $this->client()->object("$this->sObject/Id/{$newCase['id']}", [
                'Status' =>  $caseData["case"]["status"],
                'Corporativo__c' => $issuer["Id"],
                'se_cobra__c' => $issuer["Id"],
                'CurrencyIsoCode' => "USD",
                'Monto_Waiver__c' => $caseData["case"]["waiver"],
            ]);
        }

        return $this->findById($newCase['id'], ['Id', 'CaseNumber', 'codigo_it__c'])->toArray();
    }

    public function create(array $data)
    {
        return $this->client()->custom('/pushBookingData', [
            'method' => 'POST',
            'body' => [
                "sdbt" => json_encode($data)
            ]
        ]);
    }
}