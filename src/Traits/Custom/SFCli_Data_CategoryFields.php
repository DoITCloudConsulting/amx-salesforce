<?php

namespace Amx\Salesforce\Traits\Custom;

trait SFCli_Data_CategoryFields
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

    /** Data Category */
    public ?string $Data_Category__c = null;

    /** Knowledge Article */
    public ?string $Knowledge_Article__c = null;

    /** Categories */
    public ?string $Categories__c = null;

    /** Sumary1 */
    public ?float $Sumary1__c = null;

    /** Component */
    public ?string $Component__c = null;
}
