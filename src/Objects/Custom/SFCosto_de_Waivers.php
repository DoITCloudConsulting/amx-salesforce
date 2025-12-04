<?php

namespace Amx\Salesforce\Objects\Custom;

use Amx\Salesforce\Traits\Custom\SFCosto_de_WaiversFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFCosto_de_Waivers extends SFBaseObject
{
    use SFCosto_de_WaiversFields;

    protected string $sObject = 'Costo_de_Waivers__c';

    public function allFields(): array
    {
        return array_merge($this->getBaseFields(), $this->getCosto_de_WaiversFields());
    }

    public function getWaiverCostsByRegionCurrencyPdvRecordType(string $region, string $currency, string $pdv, string $recordTypeIdWavers, int $limit = 1): SFCosto_de_Waivers|array|null
    {
        $response = $this->client()
            ->select([
                'Id',
                'Costo_waiver__c',
                'Region__c',
                'CurrencyIsoCode',
                'Punto_de_Venta__c'
            ])
            ->from($this->sObject)
            ->whereRaw("Region__c INCLUDES ('" . strtoupper($region) . "')")
            ->where(['CurrencyIsoCode', '=', $currency])
            ->where(['Punto_de_Venta__c', '=', $pdv])
            ->where(['RecordTypeId', '=', $recordTypeIdWavers])
            ->limit($limit)
            ->execute();

        return $this->hydrateResponse($response);
    }
}