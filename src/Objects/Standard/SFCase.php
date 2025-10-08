<?php


namespace Amx\Salesforce\Objects\Standard;

use Amx\Salesforce\Traits\Standard\SFAccountFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFCase extends SFBaseObject
{
    protected string $sObject = 'Case';

    public function createCase(array $caseData, SFAccount $issuer, SFAccount $applicant): array
    {
        if (empty($issuer->Id) || empty($applicant->Id)) {
            throw new \InvalidArgumentException("The SFAccount objects must contain valid Id values.");
        }

        $caseData['OriginalAgency__c'] = $issuer->Id;
        $caseData['Agency__c'] = $applicant->Id;

        $newCase = $this->client()->create($this->sObject, $caseData);

        if (!empty($caseData['Status'])) {
            $this->client()->update($this->sObject, $newCase['id'], [
                'Status' => $caseData['Status']
            ]);
        }

        return $this->findById($newCase['id'], ['Id','CaseNumber','Status'])->toArray();
    }

    public function getById(string $caseId)
    {
        return $this->client()
            ->select(['codigo_it__c', 'CaseNumber'])
            ->from('Case')
            ->where(["Id", "=", $caseId])
            ->execute()["records"][0];
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