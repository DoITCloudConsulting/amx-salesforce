<?php

namespace Amx\Salesforce\Traits\Custom;

trait SFCosto_de_WaiversFields
{
    /** Record Type ID */
    public ?string $RecordTypeId = null;

    /** Last Activity Date */
    public ?string $LastActivityDate = null;

    /** Last Viewed Date */
    public ?string $LastViewedDate = null;

    /** Last Referenced Date */
    public ?string $LastReferencedDate = null;

    /** Received Connection ID */
    public ?string $ConnectionReceivedId = null;

    /** Sent Connection ID */
    public ?string $ConnectionSentId = null;

    /** Región */
    public ?string $Region__c = null;

    /** Punto de Venta */
    public ?string $Punto_de_Venta__c = null;

    /** Costo waiver */
    public ?float $Costo_waiver__c = null;

    /** Excepción País */
    public ?string $Pais__c = null;
}
