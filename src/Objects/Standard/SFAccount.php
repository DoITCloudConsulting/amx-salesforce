<?php

namespace Amx\Salesforce\Objects\Standard;

use Amx\Salesforce\Traits\Standard\SFAccountFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFAccount extends SFBaseObject
{
    use SFAccountFields;

    protected string $sObject = 'Account';

    public function getByStationNumber(?string $stationNumber = null, int $limit = 1): SFAccount|array|null
    {
        $possibleFields = [
            'IATA__c' => $this->IATA__c ?? null,
            'Branches__c' => $this->Branches__c ?? null,
            'Home_IATA__c' => $this->Home_IATA__c ?? null,
            'Codigo__c' => $this->Codigo__c ?? null,
        ];

        if (!empty($stationNumber)) {
            foreach (array_keys($possibleFields) as $field) {
                $possibleFields[$field] = $possibleFields[$field] ?? $stationNumber;
            }
        }

        $conditions = [];
        foreach ($possibleFields as $field => $value) {
            if (!empty($value)) {
                $conditions[] = [$field, '=', $value];
            }
        }

        if (empty($conditions)) {
            throw new \InvalidArgumentException("No station number fields provided in instance or parameter.");
        }

        // 4️⃣ Construir la query
        $query = $this->client()
            ->select([
                'Id',
                'Name',
                'IATA__c',
                'Branches__c',
                'Home_IATA__c',
                'Codigo__c',
                'RecordType.Id',
                'RecordType.Name',
                'Cuenta_Principal_NG__c',
                'Cuenta_Principal_NG2__c',
                'ParentId'
            ])
            ->from($this->sObject)
            ->where($conditions, 'OR')
            ->limit($limit);

        if (!empty($this->RecordTypeId)) {
            $query->where(['RecordType.Id', '=', $this->RecordTypeId]);
        }

        $response = $query->execute();
        return $this->hydrateResponse($response);
    }


    public function getByParent(string $parentId): SFAccount|array|null
    {
        $response = $this->client()
            ->select(['Id', 'ParentId', 'Name', 'Branches__c', 'Home_IATA__c', 'Cuenta_Principal_NG__c', 'Cuenta_Principal_NG2__c', 'RecordType.Name'])
            ->from($this->sObject)
            ->where(['ParentId', '=', $parentId])
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function getPrincipalAccount(string $id, string $recordTypeName, int $limit = 1): SFAccount|array|null
    {
        $response = $this->client()
            ->select(['Id', 'ParentId', 'Name', 'Branches__c', 'Home_IATA__c', 'RecordType.Name'])
            ->from($this->sObject)
            ->where(['Id', '=', $id])
            ->where(['RecordType.Name', '=', $recordTypeName])
            ->limit($limit)
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function searchAdvancedByStation(string $stationNumber): SFAccount|array|null
    {
        $response = $this->client()
            ->select([
                'Id',
                'Home_IATA__c',
                'IATA__c',
                'Branches__c',
                'RecordType.Name',
                'Tipo_de_Cliente__c',
                'Name',
                'Codigo__c',
                'Tipo_de_grupo__c'
            ])
            ->from($this->sObject)
            ->where([
                ['IATA__c', '=', $stationNumber],
                ['Branches__c', '=', $stationNumber],
                ['Codigo__c', '=', $stationNumber],
                ['Home_IATA__c', '=', $stationNumber]
            ], 'OR')
            ->whereRaw("(RecordType.Name IN ('N2 Agency (IATA Branch)', 'Tiendas de viaje', 'Grupos'))")
            ->whereRaw("(Tipo_de_grupo__c = 'GRUPOS' OR Tipo_de_Cliente__c LIKE '%WAIVERS%' OR Tipo_de_Cliente__c LIKE '%SERVICIO%')")
            ->execute();

        return $this->hydrateResponse($response);
    }
}
