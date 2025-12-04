<?php

namespace Amx\Salesforce\Objects\Custom;

use Amx\Salesforce\Traits\Custom\SFCli_Data_CategoryFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFCli_Data_Category extends SFBaseObject
{
    use SFCli_Data_CategoryFields;

    protected string $sObject = 'Cli_Data_Category__c';

    public function allFields(): array
    {
        return array_merge($this->getBaseFields(), $this->getCli_Data_CategoryFields());
    }

    public function getApprovedArticlesInSpanish(string $recordTypeIdApproved, int $limit = 5): SFCli_Data_Category|array|null
    {
        $response = $this->client()
            ->select([
                'Id',
                'Name',
                'Knowledge_Article__c',
                'Knowledge_Article__r.Url_Public_Image__c',
                'Knowledge_Article__r.Url_Slider_Image__c',
                'Knowledge_Article__r.Article__c'
            ])
            ->from($this->sObject)
            ->whereRaw("Knowledge_Article__r.Language__c = 'Español'")
            ->where(['Search_for_it__c', '=', true])
            ->whereRaw("Knowledge_Article__r.RecordTypeId = '{$recordTypeIdApproved}'")
            ->orderBy('LastModifiedDate', 'DESC')
            ->limit($limit)
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function getArticlesByInstanceAndLanguageExcludingCategories(string $instanceId, string $languageId, array $notCategories, string $recordTypeIdApproved, int $limit = 6): SFCli_Data_Category|array|null
    {
        $response = $this->client()
            ->select([
                'Knowledge_Article__r.Id',
                'Knowledge_Article__r.Name',
                'Knowledge_Article__r.Short_content__c',
                'Knowledge_Article__r.Slider_Subtittle__c',
                'Knowledge_Article__r.Subcategory__c',
                'Knowledge_Article__r.Url_Slider__c',
                'Knowledge_Article__r.UrlName_del__c',
                'Knowledge_Article__r.LastModifiedDate',
                'Categories__r.Name'
            ])
            ->from($this->sObject)
            ->where(['Knowledge_Article__r.AMX_Creative_Builder__c', '=', $instanceId])
            ->where(['Knowledge_Article__r.Language2__c', '=', $languageId])
            ->where(['Categories__r.Name', 'NOT IN', $notCategories])
            ->where(['Knowledge_Article__r.RecordTypeId', '=', $recordTypeIdApproved])
            ->orderBy('Knowledge_Article__r.LastModifiedDate', 'DESC')
            ->limit($limit)
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function getArticlesByLanguageCategoryAndComponent(string $languageId, string $category, string $componentName, int $limit = 10): SFCli_Data_Category|array|null
    {
        $response = $this->client()
            ->select([
                'Knowledge_Article__c',
                'Knowledge_Article__r.Name',
                'Knowledge_Article__r.Article__c',
                'Knowledge_Article__r.Short_content__c',
                'Knowledge_Article__r.Slider_Subtittle__c',
                'Knowledge_Article__r.Subcategory__c',
                'Knowledge_Article__r.Url_Slider__c',
                'Knowledge_Article__r.UrlName_del__c',
                'Knowledge_Article__r.LastModifiedDate',
                'Knowledge_Article__r.Url_of_all_files__c',
                'Knowledge_Article__r.DocumentType__c',
                'Categories__r.Name'
            ])
            ->from($this->sObject)
            ->where(['Knowledge_Article__r.Language2__c', '=', $languageId])
            ->where(['Categories__r.Name', '=', $category])
            ->where(['Component__c', '=', $componentName])
            ->orderBy('Knowledge_Article__r.FirstPublishedDate__c', 'DESC')
            ->limit($limit)
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function getApprovedArticlesByInstanceLanguageAndUrlNames(string $instanceId, string $languageId, string $recordTypeIdApproved, array $urlNames): SFCli_Data_Category|array|null
    {
        $response = $this->client()
            ->select([
                'Knowledge_Article__r.Id',
                'Knowledge_Article__r.Name',
                'Knowledge_Article__r.Article__c',
                'Knowledge_Article__r.Language2__r.Label_Menu__c',
                'Knowledge_Article__r.Short_content__c',
                'Knowledge_Article__r.UrlName_del__c',
                'Categories__r.Name'
            ])
            ->from($this->sObject)
            ->where(['Knowledge_Article__r.AMX_Creative_Builder__c', '=', $instanceId])
            ->where(['Knowledge_Article__r.Language2__c', '=', $languageId])
            ->where(['Knowledge_Article__r.RecordTypeId', '=', $recordTypeIdApproved])
            ->where(['Knowledge_Article__r.UrlName_del__c', 'IN', $urlNames])
            ->execute();

        return $this->hydrateResponse($response);
    }
}