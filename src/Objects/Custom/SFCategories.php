<?php

namespace Amx\Salesforce\Objects\Custom;

use Amx\Salesforce\Traits\Custom\SFCategoriesFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFCategories extends SFBaseObject
{
    use SFCategoriesFields;

    protected string $sObject = 'Categories__c';

    public function allFields(): array
    {
        return array_merge($this->getBaseFields(), $this->getCategoriesFields());
    }
}