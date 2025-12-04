<?php

namespace Amx\Salesforce\Objects\Custom;

use Amx\Salesforce\Traits\Custom\SFTradeSiteResourcesFields;
use Amx\Salesforce\Objects\SFBaseObject;

class SFTradeSiteResources extends SFBaseObject
{
    use SFTradeSiteResourcesFields;

    protected string $sObject = 'TradeSiteResources__c';

    public function allFields(): array
    {
        return array_merge($this->getBaseFields(), $this->getTradeSiteResourcesFields());
    }

    public function getByEmail(string $email, int $limit = 1): SFTradeSiteResources|array|null
    {
        $response = $this->client()
            ->select(['Id'])
            ->from($this->sObject)
            ->where(['Email__c', '=', $email])
            ->limit($limit)
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function getByHerokuId(string $herokuId): SFTradeSiteResources|null
    {
        $response = $this->client()
            ->select(['Id'])
            ->from($this->sObject)
            ->where(['Heroku_Id__c', '=', $herokuId])
            ->limit(1)
            ->execute();

        return $this->hydrateResponse($response);
    }

    public function changeStatus(string $id, ?bool $isActive = null): SFTradeSiteResources|array|null
    {
        $status = $isActive ?? $this->IsActive__c ?? true;

        $response = $this->client()->object("{$this->sObject}/{$id}", [
            'method' => 'patch',
            'body' => [
                'IsActive__c' => $status
            ]
        ]);

        return $this->hydrateResponse(['records' => [$response]]);
    }

    public function create(?SFTradeSiteResources $resource = null): array|null
    {
        $instance = $resource ?? $this;

        $payload = $instance->toArray();

        if (empty($payload)) {
            throw new \InvalidArgumentException(
                'No data provided to create TradeSiteResources record. You must either instantiate with data or pass an instance to create().'
            );
        }

        $response = $this->client()->object($this->sObject, [
            'method' => 'POST',
            'body'   => $payload,
        ]);

        return json_decode($response, true);
    }

    public function update(string $id, array $options): SFTradeSiteResources|array|null
    {
        $response = $this->client()->object("{$this->sObject}/{$id}", [
            'method' => 'patch',
            'body' => $options
        ]);

        return $this->hydrateResponse(['records' => [$response]]);
    }
}