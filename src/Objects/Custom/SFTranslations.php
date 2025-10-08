<?php

namespace Amx\Salesforce\Objects\Custom;

use Amx\Salesforce\Traits\Custom\SFTranslationsFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFTranslations extends SFBaseObject
{
    use SFTranslationsFields;

    protected string $sObject = 'Translations__c';

    public function allFields(): array
    {
        return array_merge($this->getBaseFields(), $this->getTranslationsFields());
    }
}