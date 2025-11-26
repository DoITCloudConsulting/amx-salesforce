<?php

namespace Amx\Salesforce\Traits\Custom;

trait SFSecurity_GroupsFields
{
    /** Record Type ID */
    public ?string $RecordTypeId = null;

    /** Last Viewed Date */
    public ?string $LastViewedDate = null;

    /** Last Referenced Date */
    public ?string $LastReferencedDate = null;

    /** Received Connection ID */
    public ?string $ConnectionReceivedId = null;

    /** Sent Connection ID */
    public ?string $ConnectionSentId = null;

    /** Tootls */
    public ?string $Aeromexico_Business_Tools__c = null;

    /** Domains Allows */
    public ?string $Domains_Allows__c = null;

    /** Ultima sincronización */
    public ?string $Ultima_sincronizaci_n__c = null;

    /** GSS IDs Bundle */
    public ?string $GSS_IDs_Bundle__c = null;
}
