<?php


namespace Amx\Salesforce\Objects\Standard;

use Amx\Salesforce\Traits\Standard\SFAccountFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFAccount extends SFBaseObject
{
    use SFAccountFields;

    protected string $sObject = 'Account';

    public function allFields(): array
    {
        return array_merge($this->getBaseFields(), $this->getAccountFields());
    }

    public function getByIATA(): array
    {
        if (empty($this->Branches__c) && empty($this->Home_IATA__c)) {
            throw new \InvalidArgumentException("The Branches__c or Home_IATA__c property must be set.");
        }

//        $id_salesforce = Salesforce::query('SELECT Id, ParentId, Name, Branches__c, Home_IATA__c, Cuenta_Principal_NG__c, Cuenta_Principal_NG2__c, RecordType.Name FROM Account Where ( Branches__c = \'' . $IATA . '\' OR Home_IATA__c = \'' . $IATA . '\' ) AND (RecordType__c = \'N2 Agency (IATA Branch)\' OR RecordType__c = \'N1 Agency (Home IATA)\') LIMIT 1');

        return $this->client()
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
    }

    public function getByStationNumber(string $stationNumber): array
    {
        return $this->client()
            ->select(['Id','IATA__c','Branches__c','RecordType.Id','RecordType.Name','Home_IATA__c'])
            ->from($this->sObject)
            ->where(['IATA__c', '=', $stationNumber])
            ->orWhere(['Branches__c', '=', $stationNumber])
            ->orWhere(['Home_IATA__c', '=', $stationNumber])
            ->execute();
    }

    public function getByBranch(string $branch, int $limit = 1): array
    {
        return $this->client()
            ->select(['Id','IATA__c','Branches__c','RecordType.Id','RecordType.Name','CurrencyIsoCode', 'Home_IATA__c'])
            ->from($this->sObject)
            ->where(['Branches__c', '=', $branch])
            ->limit($limit)
            ->execute();
    }
}