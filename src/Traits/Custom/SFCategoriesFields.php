<?php

namespace Amx\Salesforce\Traits\Custom;

trait SFCategoriesFields
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

    /** Imagen de la Categoria */
    public ?string $ImageCategory__c = null;

    /** Level */
    public ?float $Level__c = null;

    /** Parent Category */
    public ?string $Parent_Category__c = null;

    /** Sumary */
    public ?float $Sumary__c = null;
}
