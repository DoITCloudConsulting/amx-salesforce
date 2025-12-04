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


        if (!empty($caseData["case"]['status'])) {

            $this->client()->object("$this->sObject/Id/{$newCase['Id']}", [
                'method' => 'patch',
                'body' => [
                    'Status' =>  $caseData["case"]["status"],
                    'Corporativo__c' => $issuer->Id,
                    'se_cobra__c' => $issuer->Id,
                    'CurrencyIsoCode' => "USD",
                    'Monto_Waiver__c' => $caseData["case"]["waiver"],
                ]
            ]);
        }


        return $this->findById($newCase['Id'], ['Id', 'CaseNumber', 'codigo_it__c']);
    }

    public function create(array $data)
    {
        return json_decode($this->client()->custom('/pushBookingData', [
            'method' => 'POST',
            'body' => [
                "sdbt" => json_encode($data)
            ]
        ]), true);
    }

    public function updateCaseWithWaiver(string $caseId, string $status, string $idEmisora, string $waiverCostId, float $waiverAmount, string $currency): SFCase|array|null
    {
        $payload = [
            'Status' => $status,
            'Agencia_Emisora__c' => $idEmisora,
            'Costo_de_Waivers__c' => $waiverCostId,
            'Corporativo__c' => $idEmisora,
            'se_cobra__c' => $idEmisora,
            'Monto_Waiver__c' => $waiverAmount,
            'CurrencyIsoCode' => $currency
        ];

        $response = $this->client()->object("{$this->sObject}/{$caseId}", [
            'method' => 'patch',
            'body' => $payload
        ]);

        return $this->hydrateResponse(['records' => [$response]]);
    }
}
