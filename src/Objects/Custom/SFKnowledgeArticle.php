<?php

namespace Amx\Salesforce\Objects\Custom;

use Amx\Salesforce\Traits\Custom\SFKnowledgeArticleFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFKnowledgeArticle extends SFBaseObject
{
    use SFKnowledgeArticleFields;

    protected string $sObject = 'KnowledgeArticle__c';

    public function allFields(): array
    {
        return array_merge($this->getBaseFields(), $this->getKnowledgeArticleFields());
    }

    public function getArticleById(string $articleId): SFKnowledgeArticle|null
    {
        $response = $this->client()
            ->select([
                'Id',
                'Name',
                'Article__c',
                'Tipo_de_Noticia__c',
                'Language2__r.Label_Menu__c',
                'Posici_n_Aviso__c'
            ])
            ->from($this->sObject)
            ->where(['Id', '=', $articleId])
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function updateArticle(string $articleId, ?string $publicImageUrl, ?string $sliderImageUrl, ?string $updatedArticleContent): SFKnowledgeArticle|array|null
    {
        $payload = [
            'Url_Public_Image__c' => $publicImageUrl,
            'Url_Slider_Image__c' => $sliderImageUrl,
            'Article__c' => $updatedArticleContent
        ];

        $response = $this->client()->object("{$this->sObject}/{$articleId}", [
            'method' => 'patch',
            'body' => $payload
        ]);

        return $this->hydrateResponse(['records' => [$response]]);
    }
}