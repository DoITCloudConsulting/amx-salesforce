<?php


namespace Amx\Salesforce\Objects\Standard;

use Amx\Salesforce\Traits\Standard\SFAccountFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFAccount extends SFBaseObject
{
    use SFAccountFields;

    protected string $sObject = 'Account';

    public function getByIATA(): ?SFAccount
    {
        if (empty($this->Branches__c) && empty($this->Home_IATA__c)) {
            throw new \InvalidArgumentException("The Branches__c or Home_IATA__c property must be set.");
        }

        $response = $this->client()
            ->select([
                'Id',
                'ParentId',
                'Name',
                'Branches__c',
                'Home_IATA__c',
                'Cuenta_Principal_NG__c',
                'Cuenta_Principal_NG2__c',
                'RecordType.Name'
            ])
            ->from($this->sObject)
            ->where([
                ['Branches__c', '=', $this->Branches__c],
                ['Home_IATA__c', '=', $this->Home_IATA__c],
            ], 'OR')
            ->where([
                ['RecordType__c', '=', 'N2 Agency (IATA Branch)'],
                ['RecordType__c', '=', 'N1 Agency (Home IATA)'],
            ], 'OR')
            ->limit(1)
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function getByStationNumber(?string $stationNumber = null): SFAccount|array|null
    {
        $stationNumber ??= $this->IATA__c ?? $this->Branches__c ?? $this->Home_IATA__c;
        $recordTypeId  = $this->RecordTypeId ?? null;

        if (empty($stationNumber)) {
            throw new \InvalidArgumentException("Station number not provided or found in instance.");
        }

        $query = $this->client()
            ->select(['Id', 'IATA__c', 'Branches__c', 'RecordType.Id', 'RecordType.Name', 'Home_IATA__c'])
            ->from($this->sObject)
            ->where([
                ['IATA__c', '=', $stationNumber],
                ['Branches__c', '=', $stationNumber],
                ['Home_IATA__c', '=', $stationNumber],
            ], 'OR');

        if (!empty($recordTypeId)) {
            $query->where(['RecordType.Id', '=', $recordTypeId]);
        }

        $response = $query->execute();

        return $this->hydrateResponse($response);
    }

    public function getByBranch(string $branch, int $limit = 1): SFAccount|array|null
    {
        $response = $this->client()
            ->select(['Id', 'IATA__c', 'Branches__c', 'RecordType.Id', 'RecordType.Name', 'CurrencyIsoCode', 'Home_IATA__c'])
            ->from($this->sObject)
            ->where(['Branches__c', '=', $branch])
            ->limit($limit)
            ->execute();

        return $this->hydrateResponse($response);
    }
}