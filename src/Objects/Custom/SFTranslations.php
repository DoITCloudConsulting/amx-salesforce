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

    public function getByName(string $languageName, int $limit = 1): SFTranslations|array|null
    {
        $response = $this->client()
            ->select(['Id', 'Name'])
            ->from($this->sObject)
            ->where(['Name', '=', $languageName])
            ->limit($limit)
            ->execute();

        return $this->hydrateResponse($response);
    }
}