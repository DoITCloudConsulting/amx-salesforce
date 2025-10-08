<?php

namespace Amx\Salesforce\Traits\Custom;

trait SFTranslationsFields
{
    
    public function getTranslationsFields(): array
{
    return [
        'RecordTypeId',
            'LastViewedDate',
            'LastReferencedDate',
            'ConnectionReceivedId',
            'ConnectionSentId',
            'Language__c',
            'Label__c',
            'Page__c',
            'Component_Path__c',
            'camponuevo__c',
            'Label_Menu__c',
            'Estatus_Solicitud__c',
            'RunId__c'
    ];
}
}
