<?php

namespace Amx\Salesforce\Traits;

trait SFBaseFields
{
    protected array $baseFields = [
        'Id',
        'Name',
        'CreatedDate',
        'CreatedById',
        'LastModifiedDate',
        'LastModifiedById',
        'SystemModstamp'
    ];

    public function getBaseFields(): array
    {
        return $this->baseFields;
    }
}